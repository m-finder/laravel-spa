<template>
    <router-link tag="li" class="nav-item " :to="href" disabled>
        <a href="#" @click="toggle" class="nav-link dropdown-toggle">
            <svg-vue :icon="icon"/>
            {{ name }}
        </a>
        <slot/>
    </router-link>
</template>

<script>
    export default {
        name: 'sidebar-nav-item',
        data(){
            return {
                isActive: true,
                isExactActive: true
            }
        },
        props: {
            href: {
                type: String,
                default: ''
            },
            icon: {
                type: String,
                default: 'smile'
            },
            name: {
                type: String,
                default: ''
            },
        },
        methods: {
            toggle: function (e) {
                e.preventDefault();
                e.target.parentElement.classList.toggle('open');
            },
            navigate: function (e) {
                console.log(e)
            }
        }
    }
</script>
