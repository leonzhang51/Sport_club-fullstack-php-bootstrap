var courrielExp = /[^@]+@[^\.]+\..+$/; // expression régulière courriel //
        var motPass =/^[A-Za-z]{1,8}\d$/; // expression régulière mot de passe //
        var messageErreur="";
        var boolUserName=false;
        var boolPassWord=false;

        
        
        $(document).ready(function()
        {
            $('#envoyer').click(function()
            {
                var username = $('#username').val();
                var password = $('#password').val();
                var fonction = $('#fonction').val();
                messageErreur="";

                if (username == "")
                {
                    messageErreur += "L'identifiant n'a pas été saisi.<br>"
                }
                else if (username!= "")
                {
                    if (!courrielExp.test(username))
                    {
                    messageErreur += "L'identifiant n'a pas été saisi au bon format.<br>" 
                    } 
                    else
                    {
                        boolUserName=true;
                    }
                }
                
                if (password == "")
                {
                messageErreur += "Le mot de passe n'a pas été saisi.<br>" 
                }
                else if (password!= "")
                {
                    if (!motPass.test(password))
                    {
                    messageErreur += "Le mot de passe n'a pas été saisi au bon format.<br>" 
                    } 
                    else
                    {
                        boolPassWord=true;
                    }
                }
                
                
                if(messageErreur !="")
                {
                $('#erreurbis2').css({"display": "flex","background-color": "#ffacac"});    
                $('#erreurbis2').html(messageErreur);
                }
                
                             
                if (boolPassWord && boolUserName && messageErreur=="")
                {
                    $.ajax({
                        url: "natation.php",
                        method: "POST",
                        data: {
                            username: username,
                            password: password,
                            fonction: fonction
                        },
                        success: function(data)
                        {
                            data = data.substring(0, 2);
                            if (data == "No") {
                                $('#erreurbis2').text('Courriel ou mot de passe inconnu');
                                $('#erreurbis2').css({
                                    "display": "flex",
                                    "background-color": "#ffacac"
                                });
                            } 
                            else if(data == "01")
                            {
//                                alert (data);
                                $('#exampleModalCenter').show();
                                $('#erreurbis2').text('Bienvenue. Vous êtes bien connecté à votre compte');
                                $('#erreurbis2').css({
                                    "display": "flex",
                                    "background-color": "#7fceff"
                                });
                                setTimeout(function() {
                                    window.location.href = 'membre.php'
                                }, 3000);
                            }
                            else if(data == "02")
                            {
                                $('#exampleModalCenter').show();
                                $('#erreurbis2').text('Bienvenue. Vous êtes bien connecté à votre compte');
                                $('#erreurbis2').css({
                                    "display": "flex",
                                    "background-color": "#7fceff"
                                });
                                setTimeout(function() {
                                    window.location.href = 'teacher.php'
                                }, 3000);    
                                    
                                    
                            }
                            else if(data == "03")
                            {
                                $('#exampleModalCenter').show();
                                $('#erreurbis2').text('Bienvenue. Vous êtes bien connecté à votre compte');
                                $('#erreurbis2').css({
                                    "display": "flex",
                                    "background-color": "#7fceff"
                                });
                                setTimeout(function() {
                                    window.location.href = 'admin.php'
                                }, 3000);    
                                    
                                    
                            }
                            
                        }
                    });
                }
            });
            
            $('#croix').click(function()
            {
            $('#erreurbis2').text('');    
            $('#erreurbis2').css({"display": "none",
                                    "background-color": "#7fceff"
                                });    
                
            });
        });
        
        
        