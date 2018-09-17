$(document).ready(function() {
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
    .register('/sw.js', { scope: '/' })
    .then(function(reg) {
      console.log('Registrierung erfolgreich. Scope ist ' + reg.scope);
    }).catch(function(error) {
      console.log('Registrierung fehlgeschlagen mit ' + error);
    });
  };
});
