/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.db = '';
window.generarIdUnicoFecha = ()=>{
    let fecha = new Date();
    return Math.floor(fecha.getTime()/1000).toString(16);
}
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('alumno-component', require('./components/AlumnoComponent.vue').default);
Vue.component('docente-component', require('./components/DocenteComponent.vue').default);
Vue.component('matricula-component', require('./components/MatriculaComponent.vue').default);
Vue.component('v-select-alumno', vSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        forms:{
            alumno:{mostrar:false},
            materia:{mostrar:false},
            docente:{mostrar:false},
            nota:{mostrar:false},
            matricula:{mostrar:false},
            inscripcion:{mostrar:false},
        }
    },
    methods:{
        abrirForm(form){
            this.forms[form].mostrar = !this.forms[form].mostrar;
            this.$refs[form].obtenerDatos();
        },
        abrirBd(){
            /**
             * Mecanismos de Almacenamiento
             * 1. WebSQL
             * 2. localStorage
             * 3. IndexedDB
             */
            let indexDb = indexedDB.open('db_sistema', 1);
            indexDb.onupgradeneeded = e=>{
                let db = e.target.result;
                let tblalumno = db.createObjectStore('alumno', {keyPath:'idAlumno'});
                let tblmateria = db.createObjectStore('materia', {keyPath:'idMateria'});
                let tbldocente = db.createObjectStore('docente', {keyPath:'idDocente'});
                let tblmatricula = db.createObjectStore('matricula', {keyPath:'idMatricula'});

                tblalumno.createIndex('idAlumno', 'idAlumno', {unique:true});
                tblalumno.createIndex('codigo', 'codigo', {unique:false});

                tblmateria.createIndex('idMateria', 'idMateria', {unique:true});
                tblmateria.createIndex('codigo', 'codigo', {unique:false});

                tblmatricula.createIndex('idMatricula', 'idMatricula', {unique:true});
                tblmatricula.createIndex('idAlumno', 'idAlumno', {unique:false});
            };
            indexDb.onsuccess = e=>{
                db = e.target.result;
            };
            indexDb.onerror = e=>{
                console.log(e.target.error);
            };
        },
    },
    created(){
        this.abrirBd();
    }
});
