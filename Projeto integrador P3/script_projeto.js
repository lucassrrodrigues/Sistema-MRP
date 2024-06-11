        // Event listener para o botão "Sair"
        document.getElementById("logoutBtn").addEventListener("click", function() {
            // Aqui você pode adicionar a lógica para executar o logout, como redirecionar para uma página de login
            window.location.href = "../Login/logout.php"; // Exemplo: redireciona para a página de logout
        });

        // Event listener para o botão "Perfil"
        document.getElementById("perfilBtn").addEventListener("click", function() {
            // Aqui você pode adicionar a lógica para ir para a página de perfil do usuário
            window.location.href = "../perfil/perfil.html"; // Exemplo: redireciona para a página de perfil
        });