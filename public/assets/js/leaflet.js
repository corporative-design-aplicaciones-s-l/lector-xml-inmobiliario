document.addEventListener("DOMContentLoaded", () => {

  if (!window.PROPERTY_COORDS) return;

  const { lat, lng } = window.PROPERTY_COORDS;

  const map = L.map('propertyMap').setView([lat, lng], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.marker([lat, lng]).addTo(map);

});