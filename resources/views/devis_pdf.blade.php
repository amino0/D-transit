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
 <h2>Devis </h2>
 </div>
 <div class='pull-right'>
 <a class='btn btn-primary' href=''>Download PDF</a>
 </div>
 </div> des mot cordial pour l'envoi du pdf par mail 
 </div><br>
<table class='table table-bordered'>
 <tr>
 <th>Intituler</th>
 <th>Quantite</th>
 <th>Prix</th>

 </tr>
@foreach ($panier as $user)
 <tr>
 <td>{{ $user->intituler }}</td>
 <td>{{ $user->quantite }}</td>
 </tr>
 @endforeach
<tr>
    <td></td>
    <td></td>
    <td> <b> @foreach ($devis as $row)
{{$row->prix}}        
    @endforeach </b> </td>
</tr>
 </table>
 </div>
</body>
</html>