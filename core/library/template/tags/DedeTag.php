<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/20
// +----------------------------------------------------------------------

namespace library\template\tags;

/**
 * DedeTag 标签库
 * Class HamsterTag
 * @package library\template\tags
 */
class DedeTag
{
    // 标签开始
    private $begin = '{';

    // 标签结束
    private $end = '}';

    // 标签前缀
    private $prefix = 'dede:';

    /**
     * 解析模板
     * @param $content
     */
    public function parse(&$content)
    {
        // 解析 include
        $this->parseInclude($content);

        // 解析 global
        $this->parseGlobal($content);

        // 解析 channel
        $this->parseChannel($content);

        // 解析 type
        $this->parseType($content);

        // 解析 channelartlist
        $this->parseChannelartlist($content);

        // 解析 arclist
        $this->parseArclist($content);

        // 解析 flink
        $this->parseFlink($content);

        // 解析 field
        $this->parseField($content);

        // 解析 list
        $this->parseList($content);
    }

    /**
     * 解析 include
     */
    private function parseInclude(&$content)
    {
        $content = preg_replace_callback($this->getPattern('include'), function ($matches) {
            $path = str_replace('.htm', '', trim($matches[1]));
            return '{% include \'' . $path . '\' %}';
        }, $content);
    }

    /**
     * 解析 global
     */
    private function parseGlobal(&$content)
    {
        $content = preg_replace_callback($this->getPattern('global'), function ($matches) {
            $var = trim($matches[1]);
            return '{{ $' . $var . ' }}';
        }, $content);
    }

    /**
     * 解析 channel
     */
    private function parseChannel(&$content)
    {
        $content = preg_replace_callback($this->getPattern('channel'), function ($matches) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'type' => "'",
                'typeid' => "'",
                'row' => "'",
                'currentstyle' => '"',
            ], $attr_str);
            $attr['currentstyle'] = isset($attr['currentstyle']) ? $attr['currentstyle'] : '';

            $body_str = trim($matches[2]);
            $body_str = $this->parseResultField($body_str);

            $param = '"' . (isset($attr['type']) ? $attr['type'] : '')
                . '",'
                . (isset($attr['row']) ? $attr['row'] : 8)
                . ','
                . (isset($attr['typeid']) ? $attr['typeid'] : 0) . '';

            return "
            <?php 
            \$current_list_id = hamster_list_detail()['list_id'];
            \$currentstyle = \"{$attr['currentstyle']}\";
            ?>
            {% foreach(hamster_list({$param}) as \$index => \$item) %}
                {% if(\$item['list_id']==\$current_list_id) %}
                <?php echo str_replace('~typelink~', \$item['typeurl'], str_replace('~typename~', \$item['typename'], \$currentstyle)); ?>
                {% else %}
                {$body_str}
                {% endif %}
            {% endforeach %}
            ";
        }, $content);
    }

    /**
     * 解析 type 标签
     * @param $content
     */
    private function parseType(&$content)
    {
        $content = preg_replace_callback($this->getPattern('type'), function ($matches) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'typeid' => "'",
            ], $attr_str);

            $body_str = $this->parseResultField(trim($matches[2]));

            return "<?php 
                foreach(hamster_list('', 1, {$attr['typeid']}) as \$k=> \$item): ?>
                {$body_str}
                <?php endforeach; ?>";
        }, $content);
    }

    /**
     * 解析 channelartlist 列表
     */
    private function parseChannelartlist(&$content)
    {
        $content = preg_replace_callback($this->getPattern('channelartlist'), function ($matches) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'typeid' => "'",
            ], $attr_str);

            $body_str = $this->parseResultField(trim($matches[2]));
            $body_str = $this->parseArclist($body_str, $attr['typeid']);

            return "
            <?php foreach(hamster_list('', 100, '{$attr['typeid']}') as \$k => \$item): ?>
            {$body_str}
            <?php endforeach; ?>
            ";
        }, $content);
        return $content;
    }

    /**
     * 解析 arclist 列表
     */
    private function parseArclist(&$content, $typeid = '')
    {
        $content = preg_replace_callback($this->getPattern('arclist'), function ($matches) use ($typeid) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'typeid' => "'",
                'row' => "'",
                'titlelen' => "'",
                'type' => "'",
            ], $attr_str);

            if (!isset($attr['typeid'])) {
                $attr['typeid'] = $typeid;
            }

            $body_str = $this->parseResultField(trim($matches[2]));

            $attr = var_export($attr, true);
            return "<?php 
                foreach(hamster_arc_list({$attr}) as \$k=> \$item): ?>
                {$body_str}
                <?php endforeach; ?>";
        }, $content);
        return $content;
    }

    /**
     * 解析 flink 标签
     */
    private function parseFlink(&$content)
    {
        $content = preg_replace_callback($this->getPattern('flink'), function ($matches) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'titlelen' => "'",
                'row' => "'",
                'type' => "'",
            ], $attr_str);

            $body_str = $this->parseResultField(trim($matches[2]));
            return "
            <?php foreach(hamster_flink('{$attr['type']}', '{$attr['row']}', '{$attr['titlelen']}') as \$k => \$item): ?>
            {$body_str}
            <?php endforeach; ?>
            ";
        }, $content);
        return $content;
    }

    /**
     * 解析当前页面 field
     */
    private function parseField(&$content)
    {
        $content = preg_replace_callback($this->getPattern('current_field'), function ($matches) {
            $func = trim($matches[1]);
            if (count($matches) > 2) {
                $func = str_replace('@me', 'hamster_field(\'' . $func . '\')' . '', trim($matches[2]));
                return '<?php echo ' . $func . '; ?>';
            }
            return '{{ hamster_field(\'' . $func . '\') }}';
        }, $content);
    }

    /**
     * 解析 list
     */
    private function parseList(&$content)
    {
        $content = preg_replace_callback($this->getPattern('list'), function ($matches) {
            $attr_str = trim($matches[1]);
            $attr = $this->parseResultAttr([
                'pagesize' => "'",
            ], $attr_str);
            $body_str = $this->parseResultField(trim($matches[2]));
            return "
            <?php foreach(hamster_page_list({$attr['pagesize']}) as \$k => \$item): ?>
            {$body_str}
            <?php endforeach; ?>
            ";
        }, $content);
    }

    /**
     * 标签生成表达式
     * @param $tag
     */
    private function getPattern($tag)
    {
        $pattern = '';

        switch ($tag) {
            case 'include':
                $pattern = $this->begin . $this->prefix . $tag . '\s*filename=[\"\'](.*?)[\"\']\/' . $this->end;
                break;
            case 'global':
                $pattern = $this->begin . $this->prefix . $tag . '\.(.*?)\/' . $this->end;
                break;
            case 'channel':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
            case 'type':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
            case 'current_field':
                $pattern = [
                    $this->begin . $this->prefix . 'field' . '\.([a-zA-Z]+)[^\/]*' . '\/' . $this->end,
                    $this->begin . $this->prefix . 'field' . '\s+name=[\"\']([a-zA-Z]+)[\"\']\s+function=[\"\'](.*?)[\"\'][^\/]*' . '\/' . $this->end,
                    $this->begin . $this->prefix . 'field' . '\s+name=[\"\']([a-zA-Z]+)[\"\'][^\/]*' . '\/' . $this->end,
                ];
                break;
            case 'field':
                $pattern = [
                    '\[' . $tag . ':' . '([a-zA-Z\.]*)\s*' . '\/\]',
                    '\[' . $tag . ':' . '([a-zA-Z\.]*)\s+function=[\"\'](.*?)[\"\']\s*' . '\/\]',
                    $pattern = $this->begin . $this->prefix . $tag . '\s+name=[\"\'](.*?)[\"\']\s*\/' . $this->end,
                ];
                break;
            case 'arclist':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
            case 'channelartlist':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
            case 'flink':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
            case 'list':
                $pattern = ($this->begin . $this->prefix . $tag . '\s+(.*?)' . $this->end)
                    . '(.*?)'
                    . ($this->begin . '\/' . $this->prefix . $tag . $this->end);
                break;
        }

        if (is_array($pattern)) {
            foreach ($pattern as &$item) {
                $item = '/' . $item . '/is';
            }
            return $pattern;
        } else {
            return "/{$pattern}/is";
        }
    }

    /**
     * 解析属性
     * @param array $attrs
     * @param $str
     */
    private function parseResultAttr(array $attrs = [], $str)
    {
        $values = [];
        foreach ($attrs as $name => $symbol) {
            $symbol = preg_quote($symbol, $symbol);
            if (preg_match("/{$name}\s*=[{$symbol}](.*?)[{$symbol}]/is", $str, $matches)) {
                $values[$name] = trim($matches[1]);
            }
        }
        return $values;
    }

    /**
     * 解析字段返回字符串
     * @param $str
     * @return string|string[]|null
     */
    private function parseResultField($str)
    {
        return preg_replace_callback($this->getPattern('field'), function ($matches) {
            $func = trim($matches[1]);
            if (count($matches) > 2) {
                $func = str_replace('@me', $this->getVariable('$item.' . $func) . '', trim($matches[2]));
                return '<?php echo ' . $func . '; ?>';
            }
            return '{{ $item.' . $func . ' }}';
        }, $str);
    }

    /**
     * 获取字符.的变量
     * @param $str
     * @return string
     */
    private function getVariable($str)
    {
        if (strpos('#' . $str, '.')) {
            $result = '';
            $arr = explode('.', $str);
            foreach ($arr as $k => $item) {
                if ($k <= 0) {
                    $result .= "{$item}";
                } else {
                    $result .= "['{$item}']";
                }
            }
            return $result;
        } else {
            return $str;
        }
    }

    /**
     * 替换符号
     * @param $str
     * @return string|string[]|null
     */
    private function replaceSymbol($str)
    {
        return preg_replace(["/'/", '/"/'], '', $str);
    }
}
