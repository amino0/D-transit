<!DOCTYPE html>
<html>
<head>
 <title>Generate And Download PDF File Using dompdf — websolutionstuff.com</title>
 <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class='container'>
 <div class='row'>
 <div class='col-lg-12" style='margin-top: 15px “>
 <div class='pull-left'>
    @foreach ($devis as $row)
                                            
                                        
    <h2> Cotation <b> N° {{$row->id}} </b> pour le Fournisseur <b> {{$row->nom_fournisseur}} </b> </h2>
    @endforeach </div>
 <div class='pull-right'>
 </div>
 <br>

<table class='table table-bordered'>
 <tr>
 <th>Intituler</th>
 <th>description</th>
 <th>metrecube</th>
 <th>Quantite</th>
 <th>Prix unitaire</th>
 <th>Total</th>

 </tr>
 @php
      $t = 0;
 @endphp
@foreach ($panier as $user)
 <tr>
 <td>{{ $user->intituler }}</td>
 <td>{{ $user->description }}</td>
 <td>{{ $user->metrecube }}</td>
 <td>{{ $user->quantite }}</td>
 <td>{{ $user->prix_souhaite }}</td>
 <td>@php
    $montant_total = $user->metrecube*$user->prix_souhaite;
@endphp {{$montant_total}}</td>
 </tr>
 @php
     $t = $t + $user->metrecube*$user->prix_souhaite;
 @endphp
 @endforeach
<tr>

    <td colspan="4" align="right">
<b> Montant Total </b>
     </td>
<td> @php
   
    
@endphp <b> {{$t}} </b></td>
    </tr>
 </table>
 </div>
</body>
</html>