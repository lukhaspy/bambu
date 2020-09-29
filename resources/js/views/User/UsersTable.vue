<template>
    <div class="card">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0"><slot name="title"></slot></h3>
                </div>
                <slot name="options"> </slot>
            </div>
        </div>
        <div class="row m-3">
            <base-input
                placeholder="Search"
                class="input-group-alternative col-12 col-md-7"
                alternative=""
                addon-right-icon="fas fa-search"
                v-model="filtro"
            >
            </base-input>

            <div class="offset-5 offset-md-0 col-3 col-md-1">
                <download-csv :data="filteredTableData">
                    <base-button type="success" @click="exportarPdf()">
                        <i class="fas fa-table"></i>
                    </base-button>
                </download-csv>
            </div>
            <div class="col-3 col-md-1">
                <base-button type="primary" @click="exportarPdf()">
                    <i class="fas fa-paste"></i>
                </base-button>
            </div>
        </div>

        <div class="table-responsive">
            <base-table thead-classes="thead-light" :data="filteredTableData">
                <template slot="columns">
                    <th>Nombres</th>
                    <th>telefono</th>
                    <th>email</th>
                    <th>Cedula</th>
                    <th>Estado</th>
                </template>

                <template slot-scope="{ row }">
                    <th scope="row">
                        {{ row.nombre }}
                    </th>
                    <td>
                        {{ row.telefono }}
                    </td>
                    <td>
                        {{ row.email }}
                    </td>
                    <td>
                        {{ row.cedula }}
                    </td>
                    <td>
                        <badge type="success" v-if="row.estado == 1"
                            >Activo</badge
                        >
                        <badge type="danger" v-if="row.estado == 0"
                            >Desactivado</badge
                        >
                    </td>
                </template>
            </base-table>
        </div>
    </div>
</template>
<script>
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
export default {
    props: ["buscar"],
    data() {
        return {
            filtro: "",
            tableData: []
        };
    },
    watch: {
        buscar(val) {
            let me = this;
            if (val == 1) {
                me.getUsuarios();
            }
        }
    },
    async getUsuarios() {
        const res = await this.callApi("get", "app/users");
        if (res.status == 200) {
            this.tableData = res.data.users.data;
            console.log(this.tableData);
        }
    },
    async mounted() {
        const res = await this.callApi("get", "app/users");
        if (res.status == 200) {
            this.tableData = res.data.users.data;
            console.log(this.tableData);
        }
    },
    computed: {
        filteredTableData() {
            return this.tableData.filter(el => {
                const nombres = el.nombre.toString().toLowerCase();
                const apellidos = el.cedula.toString().toLowerCase();

                return (
                    nombres.includes(this.filtro) ||
                    apellidos.includes(this.filtro)
                );
            });
        }
    },
    methods: {
        filtrar(e) {
            this.tableData.filter(el => el.nombres == e.target.value);
        },
        exportarPdf() {
            var vm = this;
            var columns = [
                { title: "Nombres", dataKey: "nombres" },
                { title: "Apellidos", dataKey: "apellidos" },
                { title: "Telefono", dataKey: "telefono" }
            ];
            var doc = new jsPDF("p", "pt");
            doc.text("Usuarios", 40, 40);
            doc.autoTable(columns, vm.tableData, {
                margin: { top: 60 }
            });
            doc.save("usuarios-listado.pdf");
        }
    }
};
</script>
<style></style>
