<?php

namespace RichSocialMessages\Transformer;

abstract class AbstractTransformer implements TransformerInterface
{
    protected $userUrlPattern;
    
    protected $tagUrlPattern;
    
    protected $userLinkTarget;

    protected $tagLinkTarget;
    
    protected $linkLinkTarget;

    /**
     * pattern for users' links, use $1 to specify where user will be place to (e.g. http://example.com/?user=$1)
     * @param string $userUrlPattern
     * @return TransformerInterface
     */
    public function setUserUrlPattern($userUrlPattern)
    {
        $this->userUrlPattern = $userUrlPattern;
        return $this;
    }
    
    /**
     * pattern for tags' links, use $1 to specify where tag will be place to (e.g. http://example.com/?tag=$1)
     * @param string $tagUrlPattern
     * @return TransformerInterface
     */
    public function setTagUrlPattern($tagUrlPattern)
    {
        $this->tagUrlPattern = $tagUrlPattern;
        return $this;
    }
    
    /**
     * sets target for all user's links
     * @param string $userLinkTarget
     * @return TransformerInterface
     */
    public function setUserLinkTarget($userLinkTarget)
    {
        $this->userLinkTarget = $userLinkTarget;
        return $this;
    }
    
    /**
     * sets target for all tags's links
     * @param string $tagLinkTarget
     * @return TransformerInterface
     */
    public function setTagLinkTarget($tagLinkTarget)
    {
        $this->tagLinkTarget = $tagLinkTarget;
        return $this;
    }
    
    /**
     * sets target for all link's links
     * @param string $linkLinkTarget
     * @return TransformerInterface
     */
    public function setLinkLinkTarget($linkLinkTarget)
    {
        $this->linkLinkTarget = $linkLinkTarget;
        return $this;
    }
    
    /**
     * sets target for all link's in message
     * @param string $allLinksTarget
     * @return TransformerInterface
     */
    public function setAllLinksTarget($allLinksTarget)
    {
        $this->setUserLinkTarget($allLinksTarget);
        $this->setTagLinkTarget($allLinksTarget);
        $this->setLinkLinkTarget($allLinksTarget);
        return $this;
    }
    
    /**
     * transform plain links to <a> element
     * thanks to Jeff Roberson https://github.com/jmrware/LinkifyURL
     * @param string $text
     * @return string
     */
    protected function transformLinks($text)
    {
        $sectionHtmlPattern = '%
              (
                [^<]+(?:(?!<a\b)<[^<]*)*|(?:(?!<a\b)<[^<]*)+
              )
            | (
                <a\b[^>]*>
                [^<]*(?:(?!</a\b)<[^<]*)*
                </a\s*>
              )
            %ix';
        return preg_replace_callback($sectionHtmlPattern, [__CLASS__, 'linkifyCallback'], $text);
    }

    private function linkifyBase($text)
    {
        $urlPattern = '/
            (\()
            ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)
            (\))
            |
            (\[)
            ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)
            (\])
            |
            (\{)
            ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)
            (\})
            |
            (<|&(?:lt|\#60|\#x3c);)
            ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)
            (>|&(?:gt|\#62|\#x3e);)
            |
            (
            (?: ^
            | [^=\s\'"\]]
            ) \s*[\'"]?
            | [^=\s]\s+
            )
            ( \b
            (?:ht|f)tps?:\/\/
            [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]+
            (?:
            (?!
            &(?:gt|\#0*62|\#x0*3e);
            | &(?:amp|apos|quot|\#0*3[49]|\#x0*2[27]);
            [.!&\',:?;]?
            (?:[^a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]|$)
            ) &
            [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]*
            )*
            [a-z0-9\-_~$()*+=\/#[\]@%]
            )
            /imx';

        $urlReplace = '$1$4$7$10$13<a href="$2$5$8$11$14"' . ($this->linkLinkTarget ? ' target="' . $this->linkLinkTarget . '"' : '') . '>$2$5$8$11$14</a>$3$6$9$12';

        return preg_replace($urlPattern, $urlReplace, $text);
    }

    private function linkifyCallback($matches)
    {
        if (isset($matches[2])) {
            return $matches[2];
        }

        return $this->linkifyBase($matches[1]);
    }
}
