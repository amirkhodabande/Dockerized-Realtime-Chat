<template>
      <div>
            <li
                  class="list-group-item "
                  :class="className"
            >
                  <div class="d-flex flex-wrap justify-content-between">
                        <aside class="col-10">
                              <slot name="message"></slot>
                        </aside>
                        <aside class="col-2">
                              <slot name="time"></slot>
                        </aside>
                  </div>
            </li>
            <small
                  class="badge float-right"
                  :class="badgeClassName"
            >
                  <slot name="user"></slot>
            </small>
      </div>
</template>

<script>
export default {
      data() {
            return {
                  colors: this.$slots,
            };
      },

      computed: {
            className() {
                  return "list-group-item-" + this.colors.color[0].text;
            },
            badgeClassName() {
                  return "badge-" + this.colors.color[0].text;
            },
      },
};
</script>

<style>
</style>
