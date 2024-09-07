<img id="profile-logo" style="display: none !important" src="{{ auth()->user()->getLogo() }}"></img>

<script>
    window.onload = function() {
        function replaceImageSources() {
            var profileImgSrc = document.getElementById('profile-logo').src;
    
            var images = document.querySelectorAll('.fi-logo img');
    
            images.forEach(function(image) {
                image.src = profileImgSrc;
            });
        }
    
        replaceImageSources();
    
        setInterval(replaceImageSources, 3000);
    };
</script>