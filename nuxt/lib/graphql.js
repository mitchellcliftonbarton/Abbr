// Shared GraphQL fetch for all queries.
//
// Guards the response so a non-JSON / error reply surfaces a clear, debuggable
// error instead of the cryptic "Unexpected token '<', "<html><hea"... is not
// valid JSON". Throwing (rather than returning null) is intentional: a thrown
// render is NOT cached by Nitro/SWR, so the edge keeps serving the last good
// page on a transient upstream failure instead of caching a broken/empty one.
export async function fetchGraphql({ runTimeConfig, query, variables }) {
  const endpoint = runTimeConfig?.public?.graphqlEndpoint
  if (!endpoint) {
    throw new Error('[graphql] graphqlEndpoint is not configured')
  }

  let response
  try {
    response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        // Origin (WP/nginx) returns a 403 HTML page when no User-Agent is sent,
        // and Node's server-side fetch omits it by default (breaks SSR on Vercel).
        'User-Agent': 'abbr-nuxt/1.0 (+https://abbrprojects.com)',
      },
      body: JSON.stringify({ query, variables }),
    })
  } catch (err) {
    throw new Error(`[graphql] Network error contacting ${endpoint}: ${err.message}`)
  }

  const contentType = response.headers.get('content-type') || ''
  if (!response.ok || !contentType.includes('application/json')) {
    const preview = (await response.text().catch(() => '')).slice(0, 200)
    throw new Error(
      `[graphql] Unexpected ${response.status} ${response.statusText} ` +
        `(${contentType || 'no content-type'}) from ${endpoint} :: ${preview}`,
    )
  }

  const json = await response.json()
  if (json.errors?.length) {
    throw new Error(`[graphql] ${json.errors.map((e) => e.message).join(' | ')}`)
  }

  return json.data
}
