<?php global $data; ?>
<?php if (!is_home()) : ?>
<footer class="footer container clearfix">

    <div class="row">
        <div class="text fourcol">
            <?php echo stripslashes($data['coll_footer_text']);  ?>
        </div>
    </div>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>

</body>
</html>  
