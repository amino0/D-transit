<!DOCTYPE html>
<html lang="fr">
<head>
  
</head>
<body>
    
    <section>
       
        <br><br><br><br>

        <h1 id="title">Détails Commande</h1>
        <hr>
        <h2 class="detail">Information du transport </h2>
        <div style="display: flex">
            <div style="float: left">
                <div class="info">    
                    <span><b> Nom du chauffeur: </b>@foreach ($chauffeurs as $chauffeur )
                        {{$chauffeur->nom_chauffeur}}
                    @endforeach</span>
                    <br><br>
                    <span><b> Matricule : </b>@foreach ($vehicules as $vehicule )
                        {{$vehicule->numero_plaque}}
                    @endforeach</span>
                    <br><br>
                    <span><b> Type Vehicule : </b>@foreach ($vehicules as $vehicule )
                        {{$vehicule->type}}
                    @endforeach</span>
                    <br><br>
                    <span><b> Destination  : </b>@foreach ($waybills as $waybill )
                        {{$waybill->destination}}
                    @endforeach</span>
                    
                </div>
            </div>
            <div style="float: right">
                <div class="info" style="margin-left: 0px;margin-right: 25px">
                    <span><b> Nationalité : </b>Djibouti</span>
                    <br><br>
                    <span><b> Numéro de téléphone : </b>@foreach ($chauffeurs as $chauffeur )
                        {{$chauffeur->telephone}}
                    @endforeach</span>
                    <br><br>
                    <span><b> Email : </b>test@tes.com</span>
                    <br><br>
                    <span><b> Adresse : </b>@foreach ($chauffeurs as $chauffeur )
                        {{$chauffeur->addresse}}
                    @endforeach</span>
                    <br><br>
                    <span><b> Résidence : </b>Ali sabieh</span>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div>
            <hr>
            <h2 class="detail">Détails sur la marchandises</h2>
            <div style="display: flex">
                <div style="float: left">
                    <div class="info">    
                        <span><b> machandiese : </b>@foreach ($marchandises as $marchandise )
                            {{$marchandise->intituler}}
                        @endforeach </span>
                        <br><br>
                        <span><b> Quantite : </b> @foreach ($waybills as $waybill )
                            {{$waybill->quantite}}
                        @endforeach</span>
                        <br><br>
                        <span><b> metrecube : </b> @foreach ($waybills as $waybill )
                            {{$waybill->metrecube}}
                        @endforeach</span>
                    </div>
                </div>
                <div style="float: right">
                    <div class="info" style="margin-left: 0px;margin-right: 25px">
                        <span><b> Status  : </b>en cours</span>
                        <br><br>
                        <span><b> Date du rendez-vous : </b>@foreach ($waybills as $waybill )
                            {{$waybill->created_at}}
                        @endforeach</span>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
       
    </section>
</body>
</html>