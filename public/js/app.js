//import { userInfo } from "os";

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

// DEBUT DE MES SCRIPTS
/*
// apparition du message d'inscription au bout de 5 secondes
  window.onload = function() {
    setTimeout(function()
    {
      document.getElementById("info").style.display = "block";
    }, 5000);
  }
*/

// dans cet objet j'appele toutes mes classes
class Main
 {
  constructor() {
    this.map = new Gmap();
    this.map.initMap();
  }
}

// création de la classe Gmap
class Gmap 
{ 
  
  constructor () {
    this.infoMember = document.getElementById('infoMember');
    this.nomMembre = document.getElementById('nomMembre');
    this.ville = document.getElementById('ville');
    this.categorie = document.getElementById('categorie');
    this.message = document.getElementById('message');
    
  }
  
    initMap() {
      let france = {lat: 45.413340, lng: 0.788320};
     
      let map = new google.maps.Map(document.getElementById('map'), {
     
      zoom: 6.0,
      center: france
    });
  
    $(document).ready(function(){

      $.ajax({
          url : 'members.json',
          type : 'GET',
          dataType : 'json',
     
          success:function(response){
        
            let geocoder = new google.maps.Geocoder();
            let oms = new OverlappingMarkerSpiderfier(map);
            let markers = [];
            let req = response;
            let villes =[];
            let usersByCity = {};

            $.each(req, function(i) {
       
              // methode pour mettre les premières lettres en majuscule
              String.prototype.ucFirst=function(){return this.substr(0,1).toUpperCase()+this.substr(1);}
          
              let mess = req[i]["messages"];
              console.log(mess);
              let ville =req[i]["location"];
              let Ville = ville.ucFirst();
              let prenom = req[i]["firstName"];
              let preNom = prenom.ucFirst();
              let nom = req[i]["lastName"];
              let Nom = nom.ucFirst();
              let slug = req[i]["slug"];
              let rep = req[i]['categories'];
                  let cat = '';
                      for (let j= 0; j < rep.length;j++) { 
   
                        cat += rep[j].name + ' ';
                    }
                  
              if (villes.indexOf(ville) < 0) {

                usersByCity[ville]=[];
                villes.push(ville);
              } 
          
              usersByCity[ville].push({
                nom: Nom,
                prenom: preNom,
                ville: ville,
                categories: cat,
                id: req[i]["id"],
              })
        
              // geocodage des villes
              geocoder.geocode( { 'address': ville }, function(results) { 
                let icone = "images/marker3.png";
                // si plusieurs villes sont identiques je mets un marker vert
                let city = usersByCity[ville];
            
                 if (city.length > 1) {
                   icone = "images/marker.png";
                  } 

                let marker = new google.maps.Marker({
                  map: map,
                  icon: icone,
                  position: results[0].geometry.location     
                });
                markers.push(marker);
                oms.addMarker(marker);
                    
                marker.addListener('mouseover', ()=> {
                  
                  this.infoMember.style.display = "block";
                  this.nomMembre.innerHTML = "Membre: "  + preNom + ' ' + Nom;  
                  this.ville.innerHTML = "Ville: " + Ville;
               
                 this.categorie.innerHTML = "Catégorie(s): " + cat;
                        
                  // fonction qui afficher le lien
                  this.profil.innerHTML = "<span class='btn btn-success' style='cursor:pointer;'>Profil</span>" ;   
                  document.getElementById("profil").onclick = function(){window.location="http://127.0.0.1:8000/public_show/" + slug;};
                    map.addListener('click', ()=> {
                      this.infoMember.style.display = "none";
                  })       
                });   
              });
            });
          }
        });
      });
    }
}