<template>
    <div v-show="message">
        <p class="text-sm text-green-600">
            {{ message }}
        </p>
    </div>
</template>

<script>
export default {
    props: ['message']
}
</script>
