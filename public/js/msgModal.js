   // Cria uma instância da modal
   var myModal = new bootstrap.Modal(document.getElementById('alertModal'));

   // Captura o evento de passar o mouse sobre o ícone
   document.querySelector('.custom-tooltip').addEventListener('mouseover', function() {
       myModal.show();
   });

   // Captura o evento de remover o mouse do ícone
   document.querySelector('.custom-tooltip').addEventListener('mouseleave', function() {
       myModal.hide();
   });


   var myModalSexo = new bootstrap.Modal(document.getElementById('alertModalSexoLabel'));

   // Captura o evento de passar o mouse sobre o ícone
   document.querySelector('.custom-tooltip').addEventListener('mouseover', function() {
    myModalSexo.show();
   });

   // Captura o evento de remover o mouse do ícone
   document.querySelector('.custom-tooltip').addEventListener('mouseleave', function() {
    myModalSexo.hide();
   });

