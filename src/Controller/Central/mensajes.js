export default class{
    mostrarMensaje(msg,tipo){

        toastr.options = {
            "debug": false,
            "onclick": null,
            "timeOut": "50000",
            "closeButton": true,
            "progressBar": false,
            "newestOnTop": false,
            "showDuration": "300",
            "showEasing": "swing",
            "hideDuration": "1000",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "extendedTimeOut": "1000",
            "preventDuplicates": false,
            "positionClass": "toast-bottom-right",
          };

          if (tipo==1) {
            toastr.success(msg);
          }else{
            toastr.error(msg);
          }
    }
}