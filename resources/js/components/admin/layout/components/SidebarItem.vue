<template>
    <li :class="classList">
        <slot></slot>
    </li>
</template>

<script>
    export default {
        name: 'sidebar-nav-item',
        props: {
            classes: {
                type: [String, Array, Object],
                default: ''
            }
        },
        computed: {
            classList() {
                return [
                    'nav-item',
                    ...this.itemClasses
                ]
            },
            itemClasses() {
                const classes = this.classes
                return !classes ? [] : typeof classes === 'string' || classes instanceof String ? classes.split(' ') : Array.isArray(classes) ? classes : Object.keys(classes).filter(i => classes[i])
            }
        }
    }
</script>
