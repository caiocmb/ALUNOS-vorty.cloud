$(function () {
          // mascara CPF
          $('#cpf').mask('000.000.000-00', {
            reverse: false,
            onComplete: function(cpfValue) {
              $('#password').focus();
            }
          });


          $('#formLogin').submit(function() {

            var dados = $('#formLogin').serialize();

            $("#txt_acessar").hide();
            $("#btn_spinner").show();
            $(".enbdsbcon").prop("disabled", true); 
            // Mostra o loader e bloqueia tudo
            $('#card-loader').removeClass('d-none');
 
            $.ajax({
               type: 'POST',
               dataType: 'json',
               url: '/login/logar',
               async: true,
               data: dados,
               success: function(response) 
               {                   
                  if(response['status'] == 'success') {
                      // 1. Esconde o card de login para dar foco ao loading
                      $('.login-card, .logo-card, .system-version').fadeOut(300);                    
                      
                      // 2. Mostra o Loading Gamer com animação
                      setTimeout(function() {
                          $('#gamer-loader').fadeIn(1000);
                          
                          // 3. Aguarda a animação de progresso (2s) antes de redirecionar
                          setTimeout(function() {
                              location.href = '/home/';
                          }, 2500); 
                      }, 300);
                  }
                  else if(response['status'] == 'error')
                  { 
                    
                     toastr.error(response['message'], "Erro");

                     setTimeout(function() {
                       $("#txt_acessar").show();
                       $("#btn_spinner").hide();
                       $(".enbdsbcon").prop("disabled", false); 
                       $('#card-loader').addClass('d-none');
                     }, 300);                      
                  }
                  else
                  {
                     toastr.error("Ooops! Tivemos algum probleminha, atualize a página e tente novamente.", "Erro");

                     setTimeout(function() {
                       $("#txt_acessar").show();
                       $("#btn_spinner").hide();
                       $(".enbdsbcon").prop("disabled", false); 
                       $('#card-loader').addClass('d-none');
                     }, 300);  
                  }
               },
               error: function (error) 
               {                 
                 toastr.error(JSON.stringify(error), "Erro");

                 setTimeout(function() {
                   $("#txt_acessar").show();
                   $("#btn_spinner").hide();
                   $(".enbdsbcon").prop("disabled", false); 
                   $('#card-loader').addClass('d-none');
                 }, 300); 
               }
             }); 

             return false;
           });

        });