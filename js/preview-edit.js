// preview-edit.js
document.addEventListener('DOMContentLoaded', function() {
    const inputFoto = document.getElementById('foto_perfil_edit');
    const preview   = document.getElementById('preview-container-edit');
  
    if (!inputFoto) return;
  
    inputFoto.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (!file) return;
  
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.innerHTML =
          `<img src="${e.target.result}"
                width="150" height="150"
                style="object-fit: cover; border-radius: 8px;">`;
      };
      reader.readAsDataURL(file);
    });
  });