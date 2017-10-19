<?php $view = View::general($id, 'news') ?>
<?php include('doctype.php') ?>
<?php include('head.php') ?>
<div class="mauto newsDE-box">
    <h1 class="fz22"><?php echo $view->title  ?></h1>
    <div class="aside"><p>发布时间：<?php echo $view->time ?></p><span>|</span><p>发布者：<?php echo $view->name ?></p></div>
    <div class="newsDE-content">
       <?php echo $view->content ?>
    </div>

    <div class="caseDE-pager big">
        <div class="caseDE-l fl">
            <?php echo $view->prev ?>
        </div>
        <div class="caseDE-r fr">
            <?php echo $view->next ?>

        </div>
    </div>
    <div class="caseDE-pager small">
        <div class="caseDE-l fl">
            <?php echo $view->prev2 ?>
        </div>
        <div class="caseDE-r fr">
            <?php echo $view->next2 ?>

        </div>
    </div>
</div>
<?php include('foot.php') ?>