export const nl2br = (text) => {
  if (!text || typeof text !== 'string') return ''
  return text.replace(/\n/g, '<br>')
}

export const stripTags = (text) => {
  if (!text || typeof text !== 'string') return ''
  return text.replace(/<[^>]*>?/g, '')
}
