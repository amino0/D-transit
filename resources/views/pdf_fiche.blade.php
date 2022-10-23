<h1>Information Commande</h1>
<h3 class="">Bill of lading :@foreach ($commande as $row) <b>{{$row->bl}}</b>  @endforeach
</h3>  
                        
<p>  <b>Fournisseur </b> :  {{$row->nom_fourniseur}}
<p>  <b>Date BL </b> :  {{$row->date_bl}} -- <b>Client </b> :  {{$row->nom_client}}
<br>          
<b>@foreach ($sumcommande as $row) Montant Total </b> : @php
    $montanttotal = $row->sumtotal;
@endphp {{$row->sumtotal}} $
<br>@endforeach
<b>@foreach ($summontant_paye as $row) Montant Payé </b> : 
@php
    $montantpayer = $row->summontant_paye;
@endphp 
{{$row->summontant_paye}} $
<br>@endforeach
<b>@php $rest = $montanttotal - $montantpayer  @endphp Montant Restant </b> : {{$rest}} $
<br>
</p>
<p>
 <b>   Total debours : </b> @foreach ($sumdebours as $row) 
    @php
        $sumdebour = $row->sumprix;
        $sumdebourdolqr = $sumdebour /177.75;
       $sumdebourdolqr = round($sumdebourdolqr,2);
    @endphp
 {{$row->sumprix}} Djf soit {{$sumdebourdolqr}} $

<br>@endforeach
</p>
<p>
 <b>   Total Cubage  : </b> @foreach ($cubemarchandise as $row) 
    @php
    $cubagesum = $row->cubagesum;
@endphp
    {{$row->cubagesum}}   m³
   <br>@endforeach
</p>
<p>
    @php
    $prixach = ($montanttotal + ($sumdebourdolqr)) / $cubagesum;
  $priachat =  round($prixach,2);
   
@endphp
<b> Prix d'achat par metrecube : </b> {{$priachat}} $ / m³

</p>

<h1>Information paiement</h1>
<table class="table mb-4">
    <caption>Listes des paiements </caption>
    <thead>
          <tr>
              <th class="text-center">#</th>
              <th>Date paiement</th>
              <th>Montant</th>
              <th>N° compte</th>
              <th>Créé le</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($paiements as $row) 
        <tr>
              <td class="text-center">{{$row->id}}</td>
              <td class="text-primary">{{$row->date_paiement}}</td>
              <td>{{$row->montant_paye}}</td>
              <td>{{$row->numero_compte}}</td>
              <td>{{$row->created_at}}</td>
             
          </tr>
          @endforeach
      </tbody>
  </table>
  <h1>Information debours</h1>
  <table class="table mb-4">
    <caption>Listes des debours </caption>
    <thead>
          <tr>
              <th class="text-center">#</th>
              <th>Type</th>
              <th>Montant</th>
              <th>Créé le</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($debours as $row) 
        <tr>
              <td class="text-center">{{$row->id}}</td>
              <td>{{$row->type_debours}}</td>
              <td>{{$row->prix}}</td>
              
              <td> {{$row->created_at}}</td>
          </tr>
          @endforeach
      </tbody>
  </table>
  <h1>Information waybill</h1>
  <table class="table mb-4">
    <caption>Listes des waybills </caption>
    <thead>
          <tr>
              <th class="text-center">#</th>
              <th>Metrecube</th>
              <th>Quantite</th>
              <th>Destination</th>
              <th>créé le</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($waybills as $row) 
        <tr>
              <td class="text-center">{{$row->id}}</td> 
              <td class="text-primary">{{$row->metrecube}}</td>

              <td class="text-primary">{{$row->quantite}}</td>

              <td>{{$row->destination}}</td>         
              <td> {{$row->created_at}}</td>
          </tr>
          @endforeach
      </tbody>
  </table>

  <h1>Information Marchandises</h1>
  <table class="table mb-4">
    <caption>Listes des marchandises </caption>
    <thead>
          <tr>
              <th class="text-center">#</th>
              <th>Intitulé</th>
              <th>Description</th>
              <th>Quantite</th>
              <th>cubage</th>
              <th>Montant</th>
              <th>créé le</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($marchandise as $row) 
        <tr>
              <td class="text-center">{{$row->id}}</td>
              <td class="text-primary">{{$row->intituler}}</td>
              <td class="text-primary">{{$row->description}}</td>
              <td>
              @php
                  $quantite = $row->quatite;
                  $waybill_quantite = $row->waybill_quantite;

                  $totot_quantie = $quantite - $waybill_quantite;
              
              @endphp
                
                {{$totot_quantie}}</td>
              <td>
                @php
                  $cubage = $row->cubage;
                  $waybill_cubage = $row->waybill_cubage;

                  $totot_cubage = $cubage - $waybill_cubage;
              @endphp
                {{$totot_cubage}}</td>
              <td>{{$row->prix_unitaire}}</td>
              
              <td> {{$row->created_at}}</td>
          </tr>
          @endforeach
      </tbody>
  </table>