import Swal from 'sweetalert2';

export default class {
    async alerta(type,msj,title, buttonmsj){
        if (type=="error") {
              Swal.fire({
                title: title,
                text: msj,
                icon: 'error',
                confirmButtonText: buttonmsj
              });
        }
        if (type=="info") {
            Swal.fire({
                title: title,
                text: msj,
                icon: 'info',
                confirmButtonText: buttonmsj
              });
        }
        if (type=="confirmation") {
            return await Swal.fire({
                title: title,
                text: msj,
                //position: 'top-end',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:   'Cancelar',
                confirmButtonText: msj
              });
        }
    }
}