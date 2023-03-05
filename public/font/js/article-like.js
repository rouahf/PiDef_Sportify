<script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeBtn = document.getElementById('like-btn');
            const likesCount = document.getElementById('likes');

            likeBtn.addEventListener('click', function() {
                if (likeBtn.classList.contains('active')) {
                    // unlike article
const articleId = likesCount.parentElement.parentElement.dataset.articleId;
fetch('{{ path('app_dislike', {'id': '__id__'}) }}'.replace('__id__', articleId), { method: 'POST' })                       
 .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Error: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            likesCount.textContent = data.likes;
                            likeBtn.classList.remove('active');
                            likeBtn.textContent = 'Like';
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                } else {
                    // like article
fetch('{{ path('app_like', {'id': '__id__'}) }}'.replace('__id__', articleId), { method: 'POST' })
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Error: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            likesCount.textContent = data.likes;
                            likeBtn.classList.add('active');
                            likeBtn.textContent = 'Unlike';
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                }
            });
        });
    </script>