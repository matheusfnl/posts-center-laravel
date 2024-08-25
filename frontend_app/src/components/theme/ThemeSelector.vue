<script setup lang="ts">
  import { ref, computed, onMounted } from 'vue';
  import SunIcon from '@/icons/SunIcon.vue';
  import MoonIcon from '@/icons/MoonIcon.vue';

  const dark_theme_enabled = ref(false);

  const getThemeIcon = computed(() => {
    if (dark_theme_enabled.value) {
      return SunIcon;
    }

    return MoonIcon;
  });

  const toggleTheme = () => {
    if (dark_theme_enabled.value) {
      dark_theme_enabled.value = false;
      localStorage.setItem('@dark-theme', '0');
      return document.body.classList.remove('dark-theme');
    }

    dark_theme_enabled.value = true;
    localStorage.setItem('@dark-theme', '1');
    return document.body.classList.add('dark-theme');
  };

  onMounted(() => {
    const dark_theme = JSON.parse(localStorage.getItem('@dark-theme') || '0');

    if (dark_theme) {
      dark_theme_enabled.value = true;
      return document.body.classList.add('dark-theme');
    }
  })
</script>

<template>
  <div class="theme-selector">
    <component :is="getThemeIcon" @click="toggleTheme" />
  </div>
</template>

<style scoped>
  .theme-selector {
    position: absolute;
    top: 16px;
    right: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
  }

  .theme-selector * { fill: var(--text-500); }
</style>