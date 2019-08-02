const storage = window.localStorage

const table = 'laravel-storage'

export function set(settings) {
  if (!window.JSON || !window.JSON.parse) return

  settings = typeof settings === 'object'
    ? settings
    : { key: settings }

  const data = storage[table] ? JSON.parse(storage[table]) : {}

  if ('value' in settings) {
    data[settings.key] = settings.value
  } else {
    Object.keys(settings).forEach(function(item, index) {
      data[item] = settings[item]
    })
  }
  storage[table] = JSON.stringify(data)
}

export function get(key) {
  const data = JSON.parse(storage.getItem(table))
  try {
    return data[key]
  } catch (e) {
    return null
  }
}

export function remove(key = null) {
  if (key === null) {
    storage.removeItem(table)
  } else {
    const data = JSON.parse(storage[table])
    delete data[key]
  }
}
