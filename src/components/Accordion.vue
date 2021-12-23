<template>
  <div class="accordion is-flex is-flex-direction-column">
    <div class="accordion-heading is-flex is-flex-direction-row is-justify-content-space-between vertical-align">
      <div class="is-clickable vertical-align" @click="toggle">
        <mc-icon icon="expand" height="24" :class="expanded ? 'rotate-once-180 mr-2' : 'mr-2'" />
        <slot name="header" />
      </div>

      <slot name="header-append" />
    </div>

    <div class="background-white-50" :class="expanded ? 'slide-down' : 'slide-up'">
      <slot name="content" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Accordion',
  data: () => ({
    expanded: true
  }),
  methods: {
    toggle () {
      this.expanded = !this.expanded
    }
  }
}
</script>
