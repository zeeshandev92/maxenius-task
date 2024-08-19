// utils.js

export async function getSessionToken(appBridge) {
  try {
    // Use the provided app bridge instance to fetch the session token
    const token = await appBridge.getSessionToken
    return token
  } catch (error) {
    console.error('Error fetching session token:', error)
    throw error // Rethrow the error for handling in the calling code
  }
}
