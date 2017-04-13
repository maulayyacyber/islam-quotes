<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div class="row">
                <div class="col-md-6">
                    Copyright © 2017 - Mutiara Islam Apps, All rights reserved.
                </div>
                <div class="col-md-6">
                    <div class="footer-menu" style="text-align: right;">
                        <div class="menu-footer-menu-container">
                            <ul id="menu-footer-menu" class="menu" style="list-style: none;padding: 0px;margin: 0px;">
                                <li><a style="color: #080606;text-decoration: none" href="<?php echo base_url() ?>about/">About</a></li>
                                <li><a style="color: #080606;text-decoration: none" href="<?php echo base_url() ?>donations/">Donations</a></li>
                                <li><a style="color: #080606;text-decoration: none" href="<?php echo base_url() ?>download/">Download</a></li>
                                <li><a style="color: #080606;text-decoration: none" href="<?php echo base_url() ?>terms/">Terms & Conditions</a></li>
                                <li><a style="color: #080606;text-decoration: none" href="<?php echo base_url() ?>contact/">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    $(document).ready(function() {

        $('[data-toggle="tooltip"]').tooltip()

        var total_record = 0;
        var total_groups = <?php if(isset($total_data)) { echo $total_data; }else { echo '0'; }; ?>;
        $('#results').load("<?php echo base_url() ?>home/load_more", {'group_no':total_record}, function() {total_record++;});
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() == $(document).height())
            {
                if(total_record <= total_groups)
                {
                    loading = true;
                    $('.loader_image').show();
                    $.post('<?php echo site_url() ?>home/load_more',{'group_no': total_record},
                        function(data){
                            if (data != "") {
                                $("#results").append(data);
                                $('.loader_image').hide();
                                total_record++;
                            }
                        });
                }
            }
        });
    });
</script>
</body>
</html>