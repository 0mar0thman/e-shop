<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?= $js; ?>bootstrap.bundle.min.js"></script>
<script src="<?= $js; ?>all.min.js"></script>
<script src="<?= $js; ?>jquery-ui.min.js"></script>
<script src="<?= $js; ?>jquery.selectBoxIt.min.js"></script>

<script src="<?= $js; ?>backend.js"></script>

<script>
    AOS.init();
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.dropdown').on('show.bs.dropdown', function() {
            $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
        });
 
        $('.dropdown').on('hide.bs.dropdown', function() {
            $(this).find('.dropdown-menu').stop(true, true).slideUp(300);
        });
    });
</script>
</body>

</html>