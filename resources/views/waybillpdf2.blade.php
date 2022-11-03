<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministere de la santé</title>
    <style>
        * {
            margin: 0;
        }
        #title {
            text-align: center;
            padding: 45px;
            background-color: #27b7a3;
            border: 1px solid;
            border-radius: 30px;
            font-size: 30px;
            width: 65%;
            margin-left: auto !important; 
            margin-right: auto !important; 
        }
        hr {
            margin-left: auto !important; 
            margin-right: auto !important;
            width: 670px;
            margin-top: 40px;
            margin-bottom: 20px;
            border: 1px solid #000000;
        }
        .detail {
            text-align: center;
        }
        .info {
            margin-top: 30px;
            margin-left: 70px;
            font-size: 19px;
        }
        .otherdiv {
            margin-top: 250px;
        }
    </style>
</head>
<body>
    
    <section>
        <div>
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/Santebanner.png'))) }}" alt="" width="100%">
        </div>
        <br><br><br><br>

        <h1 id="title">Convocation du test PCR</h1>
        <hr>
        <h2 class="detail">Détails du patient</h2>
        <div style="display: flex">
            <div style="float: left">
                <div class="info">    
                    <span><b> Nom : </b>{{ $user->nomcomplet }}</span>
                    <br><br>
                    <span><b> Date de naissance : </b>{{ $user->date_naissance->format('d/m/Y') }}</span>
                    <br><br>
                    <span><b> Sexe : </b>{{ $user->sexe }}</span>
                    <br><br>
                    <span><b> État civil : </b>{{ $user->etat_civil }}</span>
                    <br><br>
                    <span><b> Nom de la mère : </b>{{ $user->nom_mere }}</span>
                    
                </div>
            </div>
            <div style="float: right">
                <div class="info" style="margin-left: 0px;margin-right: 25px">
                    <span><b> Nationalité : </b>{{ $user->nationalite }}</span>
                    <br><br>
                    <span><b> Numéro de téléphone : </b>{{ $user->numerotel }}</span>
                    <br><br>
                    <span><b> Email : </b>{{ $user->email }}</span>
                    <br><br>
                    <span><b> Adresse : </b>{{ $user->adresse }}</span>
                    <br><br>
                    <span><b> Résidence : </b>{{ $user->region_residence }}</span>
                </div>
            </div>
        </div>
        <br>
        <div class="otherdiv">
            <hr>
            <h2 class="detail">Détails sur test</h2>
            <div style="display: flex">
                <div style="float: left">
                    <div class="info">    
                        <span><b> Raison du test : </b>{{ $user->raison_test }}</span>
                        <br><br>
                        <span><b> Région du diagnostic : </b>{{ $user->region_diagnostic }}</span>
                    </div>
                </div>
                <div style="float: right">
                    <div class="info" style="margin-left: 0px;margin-right: 25px">
                        <span><b> Status du test : </b>{{ $user->status_test }}</span>
                        <br><br>
                        <span><b> Date du rendez-vous : </b>{{ $user->date_rendezvous->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="info">
            <img src="data:image/png;base64,{!! $qrcode !!}" width="200" height="200">
        </div>
    </section>
</body>
</html>