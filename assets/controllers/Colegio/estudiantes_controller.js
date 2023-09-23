import { Controller } from '@hotwired/stimulus';
import { Modal }    from 'bootstrap';
import Mensajes     from '../../../src/Controller/Central/mensajes';
import sweetalert   from '../../../src/Controller/Central/sweetalert';

export default class extends Controller {
    static targets = ["Mensaje", "seleccion", "modalnueEst", "modalFrmNewEst","listaEstudiantes","msjpromedio","nota"];
    static values = {
        count: Number,
        vrInicial: Number,
        noEstudiantes: Number,
        edadAcumulada: Number,
        url: String,
        modal: Object,
        //arrayEliminar:Object,

    }
    //aterrizar las variables
    modal = null;
    count = this.vrInicialValue;
    noEstudiantes = 0;
    edadAcumulada = 0;
    mensajes = new Mensajes();
    arrayEliminar=[];
    alertas= new sweetalert();



    connect() {
        //console.log("hola mundo");
    }
    contador() {
        this.count++;
        this.MensajeTarget.innerHTML = this.count;
    }
    promedio() {
        let promedioEdades = 0;
        let vrEdades = 0;
        var i = 0;
        this.seleccionTargets.forEach(element => {
            //console.log(element.checked);
            //console.log(element.dataset.edadestud);
            if (element.checked == true) {
                i++;
                vrEdades = vrEdades + parseInt(element.dataset.edadestud);
            }
            // console.log(object);
            promedioEdades = vrEdades / i;
            this.MensajeTarget.innerHTML = "Promedio de edades " + promedioEdades;
        });
    }

    promedioNew(event) {
        if (event.target.checked == true) {
            this.noEstudiantes++;
            this.edadAcumulada = this.edadAcumulada + parseInt(event.params.edad);
            this.arrayEliminar.push(event.params.idestudiante);
        } else {
            this.noEstudiantes--;
            this.edadAcumulada = this.edadAcumulada - parseInt(event.params.edad);

            let index=this.arrayEliminar.indexOf(event.params.idestudiante);
            this.arrayEliminar.splice(index,1);

        }
        let promEdades = this.edadAcumulada / this.noEstudiantes;
        this.MensajeTarget.innerHTML = "Pormedio de edades=>" + promEdades;
        console.log(this.arrayEliminar);
    }
    async promFecth() {
        // console.log('URL:'+this.urlValue);

        let form = new FormData();
        let i = 0;
        let vrEdades = 0;
        let promedioEdades = 0;

        this.seleccionTargets.forEach(element => {

            if (element.checked == true) {
                i++;
                vrEdades = vrEdades + parseInt(element.dataset.edadestud);
                console.log('edades:' + element.dataset.edadestud);
                form.append(i, parseInt(element.dataset.edadestud));
            }
            promedioEdades = vrEdades / i;
            this.MensajeTarget.innerHTML = "Promedio de edades " + promedioEdades;
        });



        const respuesta = await fetch(this.urlValue, {
            method: 'POST',
            body: form
        });
        let res = await respuesta.json();
        this.MensajeTarget.innerHTML = "Promedio dedades con (fetch) => " + res.Resultado;

        // console.log(respuesta);
    }

    async nueEstudiante(event) {
        let idEstudiante=event.params.idestudiante;
        console.log(event.params.idestudiante);
        let ruta    = event.params.urlform;
        if (idEstudiante!="") {
            ruta =ruta+"/"+idEstudiante;
        }

        this.modal = new Modal(this.modalnueEstTarget);
        const formulario = await fetch(ruta);
        this.modalFrmNewEstTarget.innerHTML = await formulario.text();
        $('.selectpicker').selectpicker();
        this.modal.show();
    }

    async consEstuId(env){

        if (env.target.value!="") {
            
            //llamado al meetodo de get para consultar so exite el estudiante con su numero de cedula
            let ruta ='/colegio/estudiantes/validaidEstu/{identificacion}';
            ruta = ruta.replace('{identificacion}',env.target.value);
            const peticion = await fetch(ruta); 
            let resultado = await  peticion.json();
            if (resultado.res==true) {
                this.alertas.alerta("error","Identificacion repetida","Validacion","Cerrar");
                //this.mensajes.mostrarMensaje('Identificacion de estudiante repetida',2);
            }
        }
    }
    async eliminarEstudiantes(envet){

        /* if(!(Array.isArray(this.arrayEliminar) && !this.arrayEliminar.length)){
            console.log('arrelgo con datos ');
        } else {
            console.log('arregl vacio');
            
        } */
        if(!(Array.isArray(this.arrayEliminar) && !this.arrayEliminar.length)){
            
            let confirmacio=await this.alertas.alerta("confirmation","Desea eliminar el Estudiante","Eliminación","Eliminar");
            if (confirmacio.isConfirmed) {
                
                let ruta=envet.params.urlelim;
                let form= new FormData();
                form.append("idEliminar",this.arrayEliminar);
                const eliminar = await fetch(ruta,{
                    method:'POST',
                    body:form
                });
                //this.mensajes.mostrarMensaje('Registros Eliminados',1);
                this.arrayEliminar=[];
                // console.log(await eliminar.text());
                this.listaEstudiantesTarget.innerHTML=await eliminar.text();
                this.alertas.alerta("info","Registro eliminado Exitosamente","Eliminación","OK");
            }
        }else{
            this.mensajes.mostrarMensaje('Se debe selecionar los registros a Eliminar',2);

        }



    }

    async listarMaterias(event){

        let ruta    = event.params.urlmaterias;
       /*  if (idEstudiante!="") {
            ruta =ruta+"/"+idEstudiante;
        } */

        this.modal = new Modal(this.modalnueEstTarget);
        const formulario = await fetch(ruta);
        this.modalFrmNewEstTarget.innerHTML = await formulario.text();
       // $('.selectpicker').selectpicker();
        this.modal.show();
    }
    async notaxestudiante(event){
        let ruta    = event.params.urlnotas; 
        ruta=ruta+"/"+event.params.idestudiante; 
         this.modal = new Modal(this.modalnueEstTarget);
         const formulario = await fetch(ruta);
         this.modalFrmNewEstTarget.innerHTML = await formulario.text();
         this.promedioNotas();
         this.modal.show();
    }

    async guardarNotaEstu(event){
        let ruta    = event.params.urlnota; 
        console.log(ruta);
        let form = new FormData();
        form.append("idNota",event.params.idnota);
        form.append("nota",event.target.value);

        const actualizacion = await fetch(ruta,{
            method:'POST',
            body:form
        });

        console.log('actualizacion');
        console.log(actualizacion);
        let resultado= await actualizacion.json();
        if (resultado.Result==1) {
            this.mensajes.mostrarMensaje('Nota guardada con exito',1);
        }
        if (resultado.Result==2) {
            event.target.value=0;
            event.target.focus();
            this.mensajes.mostrarMensaje('Dato incorrecto',2);
        }
        this.promedioNotas();

    }

    async promedioNotas(){
        let promedioNotas = 0;
        var i = 0; var sumNotas=0;
        this.notaTargets.forEach(element => {
                i++;
                sumNotas = sumNotas + parseInt(element.value);
        });
        promedioNotas = sumNotas / i;

        if (promedioNotas<3) {
            this.msjpromedioTarget.className = "aler alert-danger";
        }else{
            this.msjpromedioTarget.className = "aler alert-primary";
        }
        this.msjpromedioTarget.innerHTML = "promedio del estudiante <span class='alert-link'>"+promedioNotas.toFixed(2)+"</span>";
    }

    cerraModal() {
        this.modal.hide();
        this.mensajes.mostrarMensaje('Estudiante guardado con Exito',1);
    }
}
