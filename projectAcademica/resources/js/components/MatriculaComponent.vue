<template>
    <div id="appMatricula">
        <div class="row">
            <div class="col col-md-4">
                <!--<vue-resizable :fit-parent="fit" :dragSelector="selector" :width="500">-->
                <div class="card text-white" id="carMatricula">
                    <div class="card-header bg-primary">
                        <div class="card-title position-absolute">Registro de Matricula</div>
                        <div class="d-flex flex-row-reverse">
                            <div>
                                <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-dark">
                        <form method="post" @submit.prevent="guardarMatricula" @reset="nuevoMatricula">
                            <div class="row p-1">
                                <div class="col col-md-3">Alumno:</div>
                                <div class="col">
                                    <v-select-alumno title="Seleccione el alumno" v-model="matricula.alumno" :options="alumnos" required class="form-control"/>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Ciclo:</div>
                                <div class="col">
                                    <select v-model="matricula.ciclo" required type="text" class="form-control">
                                        <option value="I">Ciclo I</option>
                                        <option value="II">Ciclo II</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="col text-center">
                                    <input class="btn btn-success" type="submit" value="Guardar">
                                    <input class="btn btn-warning" type="reset" value="Nuevo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--</vue-resizable>-->
            </div>
            <div class="col col-md-8">
                <!--<vue-resizable :dragSelector="selector" :width="600">-->
                <div class="card text-white" id="carBuscarMatricula">
                    <div class="card-header bg-primary">
                        <div class="position-absolute">Busqueda de Matriculas</div>
                        <div class="d-flex flex-row-reverse">
                            <div>
                                <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarMatricula" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandoMatricula" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                    </th>
                                </tr>
                                <tr>
                                    <th>ALUMNO</th>
                                    <th>CICLO</th>
                                    <th>FECHA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in matriculas" @click='modificarMatricula( item )' :key="item.idMatricula">
                                    <td>{{item.alumno.label}}</td>
                                    <td>{{item.ciclo}}</td>
                                    <td>{{item.fecha}}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarMatricula(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--</vue-resizable>-->
            </div>
        </div>
    </div>
</template>

<script>
    //Vue.component('vue-resizable', VueResizable.default);
    export default {
        props : ['form'],
         data:()=>{
            return {
                selector: '.card',
                fit: false,
                buscar:'',
                matriculas:[],
                alumnos : [],
                matricula:{
                    accion : 'nuevo',
                    id : 0,
                    idMatricula : '',
                    alumno : {
                        id:'',
                        label:'',
                    },
                    ciclo: '',
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['matricula'].mostrar = false;
            },
            async sincronizarDatosServidor(matricula, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : matricula
                })
                .then(resp=>{
                    if(matricula.accion=='nuevo'){
                        matricula.id = resp.data.id;
                        this.insertarLocal(matricula);//actualizar el id del matricula que se genero en el servidor con laravel y mysql
                    }
                    alertify.success(`Matricula procesado ${data.msg}`);
                })
                .catch(err=>{
                    alerttify.error(`Error al procesar el matricula ${err}`);
                })
            },
            insertarLocal(matricula){
                let store = this.abrirStore('matricula', 'readwrite'),
                    query = store.put(matricula);
                query.onsuccess = e=>{
                    this.nuevoMatricula();
                    this.obtenerDatos();
                    alertify.success('Matricula procesado con exito');
                };
                query.onerror = e=>{
                    alertify.error(`Error al procesar el matricula ${e.target.error}`);
                };
            },
            buscandoMatricula(){
                this.obtenerDatos(this.buscar);
            },
            eliminarMatricula(matricula){
                alertify.confirm('Eliminar Matriculas', `Esta seguro de eliminar la matricula del alumno ${matricula.alumno.label}?`, eok=>{
                    matricula.accion = 'eliminar';
                    let store = this.abrirStore('matricula', 'readwrite'),
                        query = store.delete(matricula.idMatricula),
                        metodo = 'DELETE',
                        url = `/matricula/${matricula.id}`;
                    this.sincronizarDatosServidor(matricula, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoMatricula();
                        this.obtenerDatos();
                        alertify.success('Matricula eliminado con exito');
                    };
                    query.onerror = e=>{
                        alertify.error(`Error al eliminar el matricula ${e.target.error}`);
                    };
                }, ecancel=>{
                    alertify.message("Elimacion cancelada");
                })
                this.nuevoMatricula();
            },
            modificarMatricula(datos){
                this.matricula = JSON.parse(JSON.stringify(datos));
                this.matricula.accion = 'modificar';
            },
            guardarMatricula(){
                let metodo = 'PUT',
                    url = `/matricula/${this.matricula.id}`;
                if(this.matricula.accion=="nuevo"){
                    this.matricula.idMatricula = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/matricula';
                }
                let matricula = JSON.parse(JSON.stringify(this.matricula));
                this.sincronizarDatosServidor(matricula, metodo, url);
                this.insertarLocal(matricula);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('matricula', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`matricula`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.matriculas = data;
                                data.map(matricula=>{
                                    let store = this.abrirStore('matricula', 'readwrite'),
                                        query = store.put(matricula);
                                    query.onsuccess = e=>{
                                        console.log(`Matricula ${matricula.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el matricula ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                alertify.error(`Error al guardar el matricula ${err}`);
                            });
                    }
                    this.matriculas = data.result.filter(matricula=>matricula.alumno.label.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    alertify.error(`Error al obtener los matriculas ${e.target.error}`);
                };
                //obtener alumnos 
                let storeAlumno = this.abrirStore('alumno', 'readonly'),
                    dataAlumno = storeAlumno.getAll();
                dataAlumno.onsuccess = e=>{
                    if( dataAlumno.result.length<=0 ){
                        fetch(`alumno`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(dataAlumno=>{
                                this.alumnos = dataAlumno;
                                dataAlumno.map(alumno=>{
                                    let store = this.abrirStore('alumno', 'readwrite'),
                                        query = store.put(alumno);
                                    query.onsuccess = e=>{
                                        console.log(`Matricula ${alumno.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el alumno ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                alertify.error(`Error al guardar el alumno ${err}`);
                            });
                    }
                    this.alumnos = dataAlumno.result.map(alumno=>{
                        return {
                            id : alumno.id,
                            label : alumno.nombre
                        }
                    });
                    console.log(this.alumnos);
                };
                dataAlumno.onerror = e=>{
                    alertify.error(`Error al obtener los alumnos ${e.target.error}`);
                };
            },
            nuevoMatricula(){
                this.matricula.accion = 'nuevo';
                this.matricula.idMatricula = '';
                this.matricula.alumno = {
                    id:'',
                    label:'',
                };
                this.matricula.ciclo = '';
            },
            abrirStore(store, modo){
                return db.transaction(store, modo).objectStore(store);
            }
        },
        created(){
            //this.obtenerDatos();
        },
    }
</script>
