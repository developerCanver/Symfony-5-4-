import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';
import Mensaje from '../../../src/Controller/Central/mensaje';
export default class extends Controller {
    static targets = ["Mensaje", "seleccion", "modalnueEst", "modalFrmNewEst"];
    static values = {
        count: Number,
        vrInicial: Number,
        noEstudiantes: Number,
        edadAcumulada: Number,
        url: String,
        modal: Object,

    }
    //aterrizar las variables
    modal = null;
    count = this.vrInicialValue;
    noEstudiantes = 0;
    edadAcumulada = 0;
    mesajes = new Mensaje();
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
        } else {
            this.noEstudiantes--;
            this.edadAcumulada = this.edadAcumulada - parseInt(event.params.edad);

        }
        let promEdades = this.edadAcumulada / this.noEstudiantes;
        this.MensajeTarget.innerHTML = "Pormedio de edades=>" + promEdades;
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
        this.modal = new Modal(this.modalnueEstTarget);
        const formulario = await fetch(event.params.urlform);
        this.modalFrmNewEstTarget.innerHTML = await formulario.text();
        $('.selectpicker').selectpicker();
        this.modal.show();
    }

    cerraModal() {
        this.modal.hide();
        this.mensajes.mostrarMensaje('Estudiante Creado con Exito',1);
    }
}
