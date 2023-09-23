import { Controller } from '@hotwired/stimulus';
import Mensajes     from '../../../src/Controller/Central/mensajes';
import sweetalert   from '../../../src/Controller/Central/sweetalert';

export default class extends Controller {

    static targets = ["listaMaterias","fromMaterias"];

    mensajes    = new Mensajes();
    alertas     = new sweetalert();

    async guardarMaterias(event){
        this.mensajes.mostrarMensaje('Materia Guardada',1);
        
        let ruta    = event.params.urlform;
        const formulario = await fetch(ruta);
        this.fromMateriasTarget.innerHTML = await formulario.text();
        //event.target.reset();
    }

    async eliminarMateria(event){
       // console.log(event.params.idmateria);
        let confirmacion= await this.alertas.alerta('confirmation','Desea eliminar materia?','Eliminar');
        if (confirmacion.isConfirmed) {

            let ruta=event.params.urleliminarmateria;
                let form= new FormData();
                form.append("idEliminar",event.params.idmateria);
                const eliminar = await fetch(ruta,{
                    method:'POST',
                    body:form
                });
        
                this.listaMateriasTarget.innerHTML=await eliminar.text();

            this.alertas.alerta('info','Materia Eliminada','Cerrar');
        }
    }


    async modificarMateria(event){
        let idmateria=event.params.idmateria;
        let ruta    = event.params.urlform;
        if (idmateria!="") {
            ruta =ruta+"/"+idmateria;
        }

        const formulario = await fetch(ruta);
        this.fromMateriasTarget.innerHTML = await formulario.text();

    }
}
