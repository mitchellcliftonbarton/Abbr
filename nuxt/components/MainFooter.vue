<template>
  <footer
    id="main-footer"
    class="p-8"
  >
    <div class="inner p-6 rounded-2xl flex flex-col justify-between items-center">
      <div class="flex justify-between items-start w-full pb-[178px]">
        <div
          v-if="footerTextLarge"
          class="text-white text-xl tracking-[-.01em] leading-[.9] font-medium translate-y-[-.12em]"
          v-html="nl2br(footerTextLarge)"
        ></div>

        <nuxt-link to="/">
          <Logo />
        </nuxt-link>
      </div>

      <div
        v-if="footerTextSub || footerLinks"
        class="flex justify-between items-end w-full"
      >
        <div
          v-if="footerTextSub"
          v-html="footerTextSub"
          class="text-white text-xs rich-text tracking-[-.02em] leading-[1] max-w-[350px]"
        ></div>

        <div
          v-if="footerLinks"
          class="links flex gap-8"
        >
          <DynamicLink
            v-for="link in footerLinks"
            :key="link.link.url"
            :href="link.link.url"
            class="play-link text-white text-xs font-secondary uppercase"
          >
            <Play />
            <span>{{ link.link.title }}</span>
          </DynamicLink>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import Logo from '~/components/Logo.vue'
import Play from '~/components/Play.vue'
import DynamicLink from '~/components/DynamicLink.vue'
import { nl2br } from '~/lib/utils'

const footerData = useState('footerData')

// computed
const footerTextLarge = computed(() => {
  return footerData.value?.footerTextLarge
})

const footerTextSub = computed(() => {
  return footerData.value?.footerTextSub
})

const footerLinks = computed(() => {
  return footerData.value?.footerLinks
})
</script>

<style scoped lang="postcss">
#main-footer {
  color: white;

  .inner {
    background-color: black;
  }

  .logo-icon {
    width: 9rem;
  }
}
</style>
