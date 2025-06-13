<template>
  <nuxt-link
    v-if="linkUrl"
    :to="linkUrl"
    :target="targetAttribute"
  >
    <slot />
  </nuxt-link>
</template>

<script setup>
// define props
const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  target: {
    type: String,
    default: null,
  },
})

// vars
const linkUrl = ref(null)
const targetAttribute = ref(null)

// function to generate link
const generateLinkUrl = (href) => {
  // Remove any leading @ characters
  const cleanHref = href.replace(/^@+/, '')

  try {
    // If it's a mailto link, return it as is
    if (cleanHref.startsWith('mailto:')) {
      return {
        url: cleanHref,
        target: null,
      }
    }

    // If it's a relative URL (starts with /), return it as is
    if (cleanHref.startsWith('/')) {
      return {
        url: cleanHref,
        target: null,
      }
    }

    // If it's an absolute URL, create URL object
    const url = new URL(cleanHref)
    return {
      url: url.pathname + url.hash,
      target: null,
    }
  } catch (e) {
    // If URL parsing fails, return the original href
    return {
      url: cleanHref,
      target: null,
    }
  }
}

// generate the link
const linkData = generateLinkUrl(props.href)

// set the link url and target
linkUrl.value = linkData?.url
targetAttribute.value = linkData?.target
</script>
