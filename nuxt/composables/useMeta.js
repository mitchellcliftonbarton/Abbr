export function useMeta(meta) {
  // Get the current head state to access defaults
  const defaultMeta = useState('defaultMeta')

  // Set new head state with proper merging
  const newHead = useHead({
    title: meta.title ?? null,
    meta: [
      {
        name: 'description',
        content: meta.description ?? defaultMeta.value.description,
      },
      {
        property: 'og:title',
        content: meta.title ?? defaultMeta.value.title,
      },
      {
        property: 'og:description',
        content: meta.description ?? defaultMeta.value.description,
      },
      {
        property: 'og:image',
        content: meta.ogImage ?? defaultMeta.value.ogImage,
      },
      {
        property: 'og:type',
        content: meta.ogType ?? defaultMeta.value.ogType,
      },
    ].filter(Boolean),
  })

  return newHead
}
