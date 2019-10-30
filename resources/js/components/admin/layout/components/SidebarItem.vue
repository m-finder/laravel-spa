<template>
    <router-link tag="li" class="nav-item " :to="href" disabled>
<!--    v-slot="{ href, route, navigate, isActive, isExactActive }"    -->
        <a href="#" @click="toggle" class="nav-link dropdown-toggle router-link-active" :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']">
            <svg-vue :icon="icon"/>
            {{ name }}
<!--            <b-nav vertical class="nav-dropdown-items">-->
<!--                <template v-for="(children, i) in item.children">-->
<!--                    <b-nav-item :to="children.url" @click="toggle">-->
<!--                        <svg-vue :icon="children.icon || 'smile'"/>-->
<!--                        {{ children.name }}-->
<!--                    </b-nav-item>-->
<!--                </template>-->
<!--            </b-nav>-->
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
