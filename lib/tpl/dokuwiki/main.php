<?php
/**
 * DokuWiki Default Template 2012
 *
 * @link     http://dokuwiki.org/template
 * @author   Anika Henke <anika@selfthinker.org>
 * @author   Clarence Lee <clarencedglee@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
header('X-UA-Compatible: IE=edge,chrome=1');

$hasSidebar = page_findnearest($conf['sidebar']);
$showSidebar = $hasSidebar && ($ACT=='show');
?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body>
<script type="text/javascript" src="<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/xheditor-1.2.2.min.js"></script>

<script type="text/javascript" src="<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/prettify/prettify.js"></script>
<link href="<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/prettify/prettify.css" type="text/css" rel="stylesheet">

    <div id="dokuwiki__site"><div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php
        echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>">

        <?php include('tpl_header.php') ?>

        <div class="wrapper group">

            <?php if($showSidebar): ?>
                <!-- ********** ASIDE ********** -->
                <div id="dokuwiki__aside"><div class="pad aside include group">
                    <h3 class="toggle"><?php echo $lang['sidebar'] ?></h3>
                    <div class="content"><div class="group">
                        <?php tpl_flush() ?>
                        <?php tpl_includeFile('sidebarheader.html') ?>
                        <?php tpl_include_page($conf['sidebar'], true, true) ?>
                        <?php tpl_includeFile('sidebarfooter.html') ?>
                    </div></div>
                </div></div><!-- /aside -->
            <?php endif; ?>

            <!-- ********** CONTENT ********** -->
            <div id="dokuwiki__content"><div class="pad group">
                <?php html_msgarea() ?>

                <div class="pageId"><span><?php echo hsc($ID) ?></span></div>

                <div class="page group">
                    <?php tpl_flush() ?>
                    <?php tpl_includeFile('pageheader.html') ?>
                    <!-- wikipage start -->
                    <?php tpl_content() ?>
                    <!-- wikipage stop -->
                    <?php tpl_includeFile('pagefooter.html') ?>
                </div>

                <div class="docInfo"><?php tpl_pageinfo() ?></div>

                <?php tpl_flush() ?>
            </div></div><!-- /content -->

            <hr class="a11y" />

            <!-- PAGE ACTIONS -->
            <div id="dokuwiki__pagetools">
                <h3 class="a11y"><?php echo $lang['page_tools']; ?></h3>
                <div class="tools">
                    <ul>
                        <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems(); ?>
                    </ul>
                </div>
            </div>
        </div><!-- /wrapper -->

        <?php include('tpl_footer.php') ?>
    </div></div><!-- /site -->

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>

<script type="text/javascript">
    var editor;
    jQuery(pageInit);

    function pageInit() {
        var allPlugin = {
            Code: {
                c: 'btnCode', t: '插入代码', h: 1, e: function () {
                    var _this = this;
                    var htmlCode = '<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="js">Javascript</option><option value="css">CSS</option><option value="php">PHP</option><option value="java">Java</option><option value="py">Python</option><option value="pl">Perl</option><option value="rb">Ruby</option><option value="cs">C#</option><option value="c">C++/C</option><option value="vb">VB/ASP</option><option value="">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';
                    var jCode = jQuery(htmlCode), jType = jQuery('#xheCodeType', jCode),
                        jValue = jQuery('#xheCodeValue', jCode), jSave = jQuery('#xheSave', jCode);
                    jSave.click(function () {
                        _this.loadBookmark();
                        _this.pasteHTML('<pre class="prettyprint lang-' + jType.val() + '">' + _this.domEncode(jValue.val()) + '</pre>');
                        _this.hidePanel();
                        return false;
                    });
                    _this.saveBookmark();
                    _this.showDialog(jCode);
                }
            }
        };
        editor = jQuery('#elm1').xheditor({
            plugins: allPlugin,
            tools: 'Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,|,Align,List,Outdent,Indent,|,Link,Unlink,Anchor,Img,Flash,Media,Hr,Emot,Table,|,Source,Print,Fullscreen,Code',
            loadCSS: '<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',
            localUrlTest: /^https?:\/\/[^\/]*?(xheditor\.com)\//i,
            remoteImgSaveUrl: '<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/saveremoteimg.php?prefix=<?php echo DOKU_BASE;?>',
            upLinkUrl: "<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/upload.php?immediate=1&prefix=<?php echo DOKU_BASE;?>",
            upLinkExt: "zip,rar,txt",
            upImgUrl: "<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/upload.php?immediate=1&prefix=<?php echo DOKU_BASE;?>",
            upImgExt: "jpg,jpeg,gif,png",
            upFlashUrl: "<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/upload.php?immediate=1&prefix=<?php echo DOKU_BASE;?>",
            upFlashExt: "swf",
            upMediaUrl: "<?php echo DOKU_BASE;?>lib/xheditor-1.2.2/demos/upload.php?immediate=1&prefix=<?php echo DOKU_BASE;?>",
            upMediaExt: "wmv,avi,wma,mp3,mid"
        });
    }
</script>
</body>
</html>
