<template>
    <div>
        <base-header
            class="header pb-5 pb-lg-0 pt-5 pt-lg-8 d-flex align-items-center"
        >
            <!-- Mask -->
            <span class="mask bg-gradient-primary opacity-8"></span>
            <!-- Header container -->
        </base-header>
        <div class="container-fluid">
            <div class="col text-right"></div>
            <div class="row">
                <div class="col">
                    <users-table
                        ><div slot="title">Usuarios</div>
                        <div slot="options">
                            <div class="col text-right">
                                <a
                                    href="#!"
                                    class="btn btn-sm btn-primary"
                                    @click="modal.show = true"
                                    >Agregar <i class="fa fa-plus"></i
                                ></a>
                            </div>
                        </div>
                    </users-table>
                </div>
            </div>
        </div>

        <modal
            :show.sync="modal.show"
            :buscar="modal.buscar"
            body-classes="p-0"
            modal-classes="modal-lg"
            footer-classes="row justify-content-center"
        >
            <div slot="header">
                <i class="fa fa-users"></i> {{ operacion.nombre }}
            </div>
            <card
                type="secondary"
                shadow
                header-classes="bg-white    "
                body-classes=" pt-lg-5"
                class="border-0"
            >
                <template>
                    <form role="form">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="">Nombre</label>
                                <base-input
                                    alternative
                                    class="mb-3"
                                    v-model="usuario.nombre"
                                    placeholder="Nombre"
                                >
                                </base-input>
                            </div>
                            <div class="col-md-4">
                                <label for="">Cedula</label>

                                <base-input
                                    alternative
                                    class="mb-3"
                                    v-model="usuario.cedula"
                                    placeholder="Cedula"
                                >
                                </base-input>
                            </div>
                            <div class="col-md-4">
                                <label for="">Telefono</label>

                                <base-input
                                    alternative
                                    class="mb-3"
                                    v-model="usuario.telefono"
                                    placeholder="Telefono"
                                >
                                </base-input>
                            </div>

                            <div class="col-md-4">
                                <label for="">Email</label>

                                <base-input
                                    alternative
                                    class="mb-3"
                                    v-model="usuario.email"
                                    placeholder="Email"
                                >
                                </base-input>
                            </div>
                            <div class="col-md-4">
                                <label for="">Rol</label>
                                <select
                                    class="form-control"
                                    v-model="usuario.rol"
                                >
                                    <option value="1">Super Usuario</option>
                                    <option value="2">Admin</option>
                                    <option value="3">Operador</option>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Usuario</label>

                                <base-input
                                    alternative
                                    class="mb-3"
                                    v-model="usuario.user"
                                    placeholder="Usuario"
                                >
                                </base-input>
                            </div>
                            <br />
                            <div class="col-md-6">
                                <label for="">Password</label>

                                <base-input
                                    alternative
                                    type="password"
                                    v-model="usuario.password"
                                    placeholder="Password"
                                >
                                </base-input>
                            </div>
                        </div>
                    </form>
                </template>
            </card>
            <div slot="footer">
                <base-button
                    type="success"
                    icon="fas fa-check-circle"
                    @click="procesar()"
                    >Guardar</base-button
                >
                <base-button type="danger" icon="fas fa-times"
                    >Cancelar</base-button
                >
            </div>
        </modal>

        <vue-snotify></vue-snotify>
    </div>
</template>
<script>
import UsersTable from "./UsersTable";
import modal from "@/components/Modal";
export default {
    name: "tables",
    components: {
        UsersTable,
        modal
    },
    mounted() {},
    data() {
        return {
            modal: { show: true, buscar: 0 },
            operacion: { nombre: "Nuevo Usuario", valor: 1 },

            usuario: {
                nombre: "",
                cedula: "",
                telefono: "",
                email: "",
                rol: "",
                user: "",
                password: ""
            }
        };
    },
    methods: {
        validar() {
            if (this.usuario) {
                return true;
            }
        },
        async procesar() {
            if (this.validar()) {
                if (this.operacion.valor == 1) {
                    const res = await this.callApi(
                        "post",
                        "app/users",
                        this.usuario
                    );
                    if (res.status == 201) {
                        this.modal.show = false;
                        this.modal.buscar = true;
                        this.$snotify.success(
                            "El usuario ha sido agregado correctamente",
                            "Finalizado",
                            {
                                timeout: 3000,
                                showProgressBar: true,
                                closeOnClick: false,
                                pauseOnHover: true
                            }
                        );
                    } else {
                        if (res.status == 403) {
                            let err = "";
                            Object.keys(res.data).forEach(function(key, index) {
                                err += res.data[key] + "<br>";
                            });

                            this.$snotify.html(
                                `<div class="snotifyToast__title"><b>Error</b></div>
  <div class="snotifyToast__body">${err}</div> `,
                                {
                                    timeout: 10000,

                                    showProgressBar: true,
                                    closeOnClick: true,
                                    pauseOnHover: true,
                                    type: "error"
                                }
                            );
                        } else {
                            this.$snotify.html(
                                `<div class="snotifyToast__title"><b>Error</b></div>
  <div class="snotifyToast__body">${res.data}</div> `,
                                {
                                    timeout: 10000,

                                    showProgressBar: true,
                                    closeOnClick: true,
                                    pauseOnHover: true,
                                    type: "error"
                                }
                            );
                        }
                    }
                } else {
                    this.$snotify.error(
                        "Por favor, complete todos los datos",
                        "Error",
                        {
                            timeout: 2000,
                            showProgressBar: true,
                            closeOnClick: false,
                            pauseOnHover: true
                        }
                    );
                }
            }
        }
    }
};
</script>
<style></style>
