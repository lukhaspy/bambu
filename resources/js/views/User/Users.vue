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
            <div class="row">
                <div class="col">
                    <users-table><div slot="title">Usuarios</div></users-table>
                </div>
            </div>
        </div>
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
    }
};
</script>
<style></style>
