// Obtener referencia al input y a la imagen
const $selectImage = document.querySelector("#selectImage"),
  $previewImage = document.querySelector("#previewImage");

// Escuchar cuando cambie
$selectImage.addEventListener("change", () => {
  // Los archivos seleccionados, pueden ser muchos o uno
  const image = $selectImage.files;
  // Si no hay archivos salimos de la función y quitamos la imagen
  if (!image || !image.length) {
    $previewImage.src = "";
    return;
  }
  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
  const firstImage = image[0];
  // Lo convertimos a un objeto de tipo objectURL
  const objectURL = URL.createObjectURL(firstImage);
  // Y a la fuente de la imagen le ponemos el objectURL
  $previewImage.src = objectURL;
});