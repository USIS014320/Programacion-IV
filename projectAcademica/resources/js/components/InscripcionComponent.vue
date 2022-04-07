<template>
  <div id="appInscripcion">
    <div class="row">
      <div class="col col-md-4">
        <div class="card text-white" id="carInscripcion">
          <div class="card-header bg-primary">
            Registro de Inscripcions
            <button
              type="button"
              class="btn-close text-end"
              data-bs-dismiss="alert"
              data-bs-target="#carInscripcion"
              aria-label="Close"
            ></button>
          </div>
          <div class="card-body text-dark">
            <form
              method="post"
              @submit.prevent="guardarInscripcion"
              @reset="nuevoInscripcion"
            >
              <div class="row p-1">
                <div class="col col-md-3">Codigo:</div>
                <div class="col col-md-4">
                  <input
                    title="Ingrese el codigo"
                    v-model="inscripcion.codigo"
                    pattern="[0-9]{3,10}"
                    required
                    type="text"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="row p-1">
                <div class="col col-md-3">Ciclo:</div>
                <div class="col">
                  <input list="materia_1" v-select="inscripcion.materia_1" />
                  <datalist id="materia_1">
                    <option value="Ciclo I"></option>
                    <option value="Ciclo II"></option>
                    <option value="Ciclo III"></option>
                    <option value="Ciclo IV"></option>
                    <option value="Ciclo V"></option>
                    <option value="Ciclo VI"></option>
                    <option value="Ciclo VII"></option>
                    <option value="Ciclo VIII"></option>
                    <option value="Ciclo IX"></option>
                    <option value="Ciclo X"></option>
                  </datalist>
                </div>
              </div>

              <div class="row p-1">
                <div class="col col-md-3">Materia 1:</div>
                <div class="col">
                  <input list="materia_1" v-select="inscripcion.materia_1" />
                  <datalist id="materia_1">
                    <option value="Programacion II"></option>
                    <option value="Programacion VI"></option>
                    <option value="Matematicas III"></option>
                    <option value="Matematicas I"></option>
                    <option value="Ingenieria de Software"></option>
                    <option value="Infraestructura Tecnologica"></option>
                    <option value="Principios de Electronica"></option>
                    <option value="Admon de Bases de Datos II"></option>
                    <option value="Formacion Transversal"></option>
                    <option value="Sistemas Operativos"></option>
                    <option value="Informatica y Sociedad"></option>
                  </datalist>
                </div>
              </div>
              <div class="row p-1">
                <div class="col col-md-3">Materia 2:</div>
                <div class="col">
                  <input list="materia_2" v-select="inscripcion.materia_2" />
                  <datalist id="materia_2">
                    <option value="Programacion II"></option>
                    <option value="Programacion VI"></option>
                    <option value="Matematicas III"></option>
                    <option value="Matematicas I"></option>
                    <option value="Ingenieria de Software"></option>
                    <option value="Infraestructura Tecnologica"></option>
                    <option value="Principios de Electronica"></option>
                    <option value="Admon de Bases de Datos II"></option>
                    <option value="Formacion Transversal"></option>
                    <option value="Sistemas Operativos"></option>
                    <option value="Informatica y Sociedad"></option>
                  </datalist>
                </div>
              </div>
              <div class="row p-1">
                <div class="col col-md-3">Materia 3:</div>
                <div class="col">
                  <input list="materia_3" v-select="inscripcion.materia_3" />
                  <datalist id="materia_3">
                    <option value="Programacion II"></option>
                    <option value="Programacion VI"></option>
                    <option value="Matematicas III"></option>
                    <option value="Matematicas I"></option>
                    <option value="Ingenieria de Software"></option>
                    <option value="Infraestructura Tecnologica"></option>
                    <option value="Principios de Electronica"></option>
                    <option value="Admon de Bases de Datos II"></option>
                    <option value="Formacion Transversal"></option>
                    <option value="Sistemas Operativos"></option>
                    <option value="Informatica y Sociedad"></option>
                  </datalist>
                </div>
              </div>
              <div class="row p-1">
                <div class="col col-md-3">Materia 4:</div>
                <div class="col">
                  <input list="materia_4" v-select="inscripcion.materia_4" />
                  <datalist id="materia_4">
                    <option value="Programacion II"></option>
                    <option value="Programacion VI"></option>
                    <option value="Matematicas III"></option>
                    <option value="Matematicas I"></option>
                    <option value="Ingenieria de Software"></option>
                    <option value="Infraestructura Tecnologica"></option>
                    <option value="Principios de Electronica"></option>
                    <option value="Admon de Bases de Datos II"></option>
                    <option value="Formacion Transversal"></option>
                    <option value="Sistemas Operativos"></option>
                    <option value="Informatica y Sociedad"></option>
                  </datalist>
                </div>
              </div>
              <div class="row p-1">
                <div class="col col-md-3">Materia 5:</div>
                <div class="col">
                  <input list="materia_5" v-select="inscripcion.materia_5" />
                  <datalist id="materia_5">
                    <option value="Programacion II"></option>
                    <option value="Programacion VI"></option>
                    <option value="Matematicas III"></option>
                    <option value="Matematicas I"></option>
                    <option value="Ingenieria de Software"></option>
                    <option value="Infraestructura Tecnologica"></option>
                    <option value="Principios de Electronica"></option>
                    <option value="Admon de Bases de Datos II"></option>
                    <option value="Formacion Transversal"></option>
                    <option value="Sistemas Operativos"></option>
                    <option value="Informatica y Sociedad"></option>
                  </datalist>
                </div>
              </div>

              <div class="row p-1">
                <div class="col col-md-3">Fecha de Inscripcion:</div>
                <div class="col col-md-4">
                  <input
                    title="Ingrese la fecha"
                    v-select="inscripcion.fecha"
                    pattern="{0000-00-00}"
                    required
                    type="date"
                    class="form-control form-control-sm"
                  />
                </div>
              </div>
              <div class="row p-1">
                <div class="col text-center">
                  <div
                    v-if="inscripcion.mostrar_msg"
                    class="alert alert-primary alert-dismissible fade show"
                    role="alert"
                  >
                    {{ inscripcion.msg }}
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="alert"
                      aria-label="Close"
                    ></button>
                  </div>
                </div>
              </div>
              <div class="row m-2">
                <div class="col text-center">
                  <input
                    class="btn btn-success"
                    type="submit"
                    value="Guardar"
                  />
                  <input class="btn btn-warning" type="reset" value="Nuevo" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col col-md-8">
        <div class="card text-white" id="carBuscarInscripcion">
          <div class="card-header bg-primary">
            Busqueda de Inscripcions
            <button
              type="button"
              @click="cerrarForm"
              class="btn-close"
              data-bs-dismiss="alert"
              data-bs-target="#carBuscarInscripcion"
              aria-label="Close"
            ></button>
          </div>
          <div class="card-body">
            <table class="table table-dark table-hover">
              <thead>
                <tr>
                  <th colspan="9">
                    Buscar:
                    <input
                      @keyup="buscandoInscripcion"
                      v-model="buscar"
                      placeholder="buscar aqui"
                      class="form-control"
                      type="text"
                    />
                  </th>
                </tr>
                <tr>
                  <th>CODIGO</th>
                  <th>CICLO</th>
                  <th>MATERIA 1</th>
                  <th>MATERIA 2</th>
                  <th>MATERIA 3</th>
                  <th>MATERIA 4</th>
                  <th>MATERIA 5</th>
                  <th>FECHA</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in inscripcions"
                  @click="modificarInscripcion(item)"
                  :key="item.idInscripcion"
                >
                  <td>{{ item.codigo }}</td>
                  <td>{{ item.materia_1 }}</td>
                  <td>{{ item.materia_2 }}</td>
                  <td>{{ item.materia_3 }}</td>
                  <td>{{ item.materia_4 }}</td>
                  <td>{{ item.materia_5 }}</td>
                  <td>{{ item.fecha }}</td>
                  <td>{{ item.matricula.label }}</td>
                  <td>
                    <button
                      class="btn btn-danger"
                      @click="eliminarInscripcion(item)"
                    >
                      Eliminar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data: () => {
    return {
      buscar: "",
      inscripcions: [],
      inscripcion: {
        accion: "nuevo",
        mostrar_msg: false,
        msg: "",
        id: 0,
        idInscripcion: "",
        codigo: "",
        materia_1: "",
        materia_2: "",
        materia_3: "",
        materia_4: "",
        materia_5: "",
        fecha: "",
        ciclo: "",
      },
    };
  },
  methods: {
    cerrarForm() {
      this.form["inscripcion"].mostrar = false;
    },
    async sincronizarDatosServidor(inscripcion, metodo, url) {
      await axios({
        method: metodo,
        url,
        data: inscripcion,
      })
        .then((resp) => {
          if (inscripcion.accion == "nuevo") {
            inscripcion.id = resp.data.id;
            this.insertarLocal(inscripcion); //actualizar el id del inscripcion que se genero en el servidor con laravel y mysql
          }
          this.inscripcion.msg = `Inscripcion procesado ${data.msg}`;
        })
        .catch((err) => {
          this.inscripcion.msg = `Error al procesar la inscripcion ${err}`;
        });
    },
    insertarLocal(inscripcion) {
      let store = this.abrirStore("inscripcion", "readwrite"),
        query = store.put(inscripcion);
      query.onsuccess = (e) => {
        this.nuevoInscripcion();
        this.obtenerDatos();
        this.inscripcion.msg = "Inscripcion procesada con exito";
      };
      query.onerror = (e) => {
        this.inscripcion.msg = `Error al procesar la inscripcion ${e.target.error}`;
      };
    },
    buscandoInscripcion() {
      this.obtenerDatos(this.buscar);
    },
    eliminarInscripcion(inscripcion) {
      if (
        confirm(`Esta seguro de eliminar la inscripcion ${inscripcion.nombre}?`)
      ) {
        inscripcion.accion = "eliminar";
        let store = this.abrirStore("inscripcion", "readwrite"),
          query = store.delete(inscripcion.idInscripcion),
          metodo = "DELETE",
          url = `/inscripcion/${inscripcion.id}`;
        this.sincronizarDatosServidor(inscripcion, metodo, url);
        query.onsuccess = (e) => {
          this.nuevoInscripcion();
          this.obtenerDatos();
          this.inscripcion.msg = "Inscripcion eliminada con exito";
        };
        query.onerror = (e) => {
          this.inscripcion.msg = `Error al eliminar la inscripcion ${e.target.error}`;
        };
      }
      this.nuevoInscripcion();
    },
    modificarInscripcion(datos) {
      this.inscripcion = JSON.parse(JSON.stringify(datos));
      this.inscripcion.accion = "modificar";
    },
    guardarInscripcion() {
      let metodo = "PUT",
        url = `/inscripcion/${this.inscripcion.id}`;
      if (this.inscripcion.accion == "nuevo") {
        this.inscripcion.idInscripcion = generarIdUnicoFecha();
        metodo = "POST";
        url = "/inscripcion";
      }
      let inscripcion = JSON.parse(JSON.stringify(this.inscripcion));
      this.sincronizarDatosServidor(inscripcion, metodo, url);
      this.insertarLocal(inscripcion);
    },
    obtenerDatos(valor = "") {
      let store = this.abrirStore("inscripcion", "readonly"),
        data = store.getAll();
      data.onsuccess = (e) => {
        if (data.result.length <= 0) {
          fetch(`inscripcion`, { credentials: "same-origin" })
            .then((res) => res.json())
            .then((data) => {
              this.inscripcions = data;
              data.map((inscripcion) => {
                let store = this.abrirStore("inscripcion", "readwrite"),
                  query = store.put(inscripcion);
                query.onsuccess = (e) => {
                  console.log(`Inscripcion ${inscripcion.nombre} guardado`);
                };
                query.onerror = (e) => {
                  console.log(
                    `Error al guardar la inscripcion ${e.target.error}`
                  );
                };
              });
            })
            .catch((err) => {
              this.inscripcion.msg = `Error al guardar la inscripcion ${err}`;
            });
        }
        this.inscripcions = data.result.filter(
          (inscripcion) =>
            inscripcion.nombre.toLowerCase().indexOf(valor.toLowerCase()) > -1
        );
      };
      data.onerror = (e) => {
        this.inscripcion.msg = `Error al obtener las inscripciones ${e.target.error}`;
      };
    },
    nuevoInscripcion() {
      this.inscripcion.accion = "nuevo";
      this.inscripcion.msg = "";
      this.inscripcion.idInscripcion = "";
      this.inscripcion.codigo = "";
      this.inscripcion.materia_1 = "";
      this.inscripcion.materia_2 = "";
      this.inscripcion.materia_3 = "";
      this.inscripcion.materia_4 = "";
      this.inscripcion.materia_5 = "";
      this.inscripcion.fecha = "";
      this.inscripcion.ciclo = "";
    },
    abrirStore(store, modo) {
      return db.transaction(store, modo).objectStore(store);
    },
  },
  created() {
    //this.obtenerDatos();
  },
};
</script>