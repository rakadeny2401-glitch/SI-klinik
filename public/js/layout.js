(function(){
    function q(id){return document.getElementById(id)}

    document.addEventListener('DOMContentLoaded', function(){
        var profileBtn = q('profileBtn');
        var profileBadge = q('profileBadge');

         if (profileBtn && profileBadge) {

            profileBtn.addEventListener('click', function(e){
                e.stopPropagation();

                var expanded = profileBtn.getAttribute('aria-expanded') === 'true';
                profileBtn.setAttribute('aria-expanded', expanded ? 'false' : 'true');

                var hidden = profileBadge.getAttribute('aria-hidden') === 'true';
                profileBadge.setAttribute('aria-hidden', hidden ? 'false' : 'true');
            });

            profileBadge.addEventListener('click', function(e){
                e.stopPropagation();
            });

            document.addEventListener('click', function(){
                if (profileBadge.getAttribute('aria-hidden') === 'false') {
                    profileBadge.setAttribute('aria-hidden', 'true');
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', function(e){
                if (e.key === 'Escape') {
                    profileBadge.setAttribute('aria-hidden', 'true');
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
})();
