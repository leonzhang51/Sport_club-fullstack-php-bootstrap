var messageErreur = "";
        var boolUserName = false;
        var boolPassWord = false;
        var idRadio = "";


                $(document).ready(function()
                {
                    $('#envoyer').click(function()
                    {
                        var idRadio = $("input:radio[name=inscription]:checked").val();
                        if (idRadio !="")
                        {
                            $.ajax({
                                url: "membre.php",
                                method: "POST",
                                data: {
                                    idRadio:idRadio
                                },
                                success: function(data)
                                {
                                    data = data.substring(0, 2);
                                    if (data == "01")
                                    {
                                    $('#modalConfirmation').modal('show'); 
                                    $('#confirmation').text('Félicitations, votre inscription s\'est effectuée avec succès !');
                                    setTimeout(function(){location.reload()}, 3500);
                                    } 
                                    else if (data == "02") 
                                    {
                                    $('#modalConfirmation').modal('show'); 
                                    $('#confirmation').text('Désolé, votre inscription n\'a pu être enregistrée !');
                                    setTimeout(function(){location.reload()}, 3500);
                                    }
                                    else if (data == "03")
                                    {
                                    $('#modalConfirmation').modal('show'); 
                                    $('#confirmation').text('Oups, vous êtes déjà inscrit à cette activité !');
                                    setTimeout(function(){location.reload()}, 3500);
                                    }
                                    else
                                    {
                                        
                                    }
                                }
                            });
                        }
                    });
                }); 