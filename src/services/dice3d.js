/* global $diceCore */
let _canvas = null
let _diceBox = null
let _options = {}

const DICE_TIMEOUT = 300

export function setDiceColor (color) {
  $diceCore.dice.dice_color = color
  $diceCore.dice.label_color = '#ffffff'
}

export function initialize (canvasId, height, options = {}) {
  if (_canvas !== null) return // Already initialized

  _options = options

  _canvas = $diceCore.id(canvasId)
  // _canvas.style.width = '100%'
  // _canvas.style.height = height + 'px'
  _canvas.style.width = window.innerWidth - 8 + 'px'
  _canvas.style.height = window.innerHeight + 'px'

  $diceCore.dice.use_true_random = false
  $diceCore.dice.use_shadows = false
  setDiceColor('#000070')

  _diceBox = new $diceCore.dice.dice_box(_canvas)
  _diceBox.animate_selector = false
  _canvas.style.display = 'none'

  if (_options.debug) {
    console.log('[dice3d] init 3D dices on canvas', canvasId)
    console.log('[dice3d] canvas size', _canvas.style.width, _canvas.style.height)
    console.log('[dice3d] canvas size', _canvas.style.width, _canvas.style.height)
  }

  // does not work for mobile devices
  // $diceCore.bind(window, 'resize', function() {
  //   if (!_canvas) return
  //   console.log('#resize')
  //   _canvas.style.width = window.innerWidth - 8 + 'px'
  //   _canvas.style.height = window.innerHeight - 8 + 'px'
  //   _diceBox.reinit(_canvas)
  // })

  // $diceCore.bind(window, 'orientationChange', function() {
  //   if (!_canvas) return
  //   console.log('#orientationChange')
  //   _canvas.style.width = window.innerWidth - 8 + 'px'
  //   _canvas.style.height = window.innerHeight - 8 + 'px'
  //   _diceBox.reinit(_canvas)
  // })
}

export function roll({ formula = '2d6', timeout, callbackFn }) {

  function before_roll(vectors, notation, callback) {
    if (_options.debug) {
      console.log('[dice3d] before_roll vectors:', vectors)
      console.log('[dice3d] before_roll notation:', notation)
      console.log('[dice3d] before_roll callback:', callback)
    }
    callback()
  }

  function notation_getter() {
    if (_options.debug) {
      console.log('[dice3d] notation_getter formula:', formula)
      console.log('[dice3d] notation_getter return', $diceCore.dice.parse_notation(formula))
    }
    return $diceCore.dice.parse_notation(formula)
  }

  function after_roll(notation, result) {
    if (_options.debug) {
      console.log('[dice3d] after_roll notation:', notation)
      console.log('[dice3d] after_roll result', result)
    }
    let total = 0
    for (let i = 0; i < result.length; i++) total += result[i]
    if (callbackFn) setTimeout(() => {
      _canvas.style.display = 'none'
      callbackFn({ dices: result, total })
    }, 500)
    else setTimeout(() => { _canvas.style.display = 'none'}, timeout || DICE_TIMEOUT)
  }

  if (_options.debug) {
    console.log('[dice3d] roll formula:', formula)
    console.log('[dice3d] roll timeout:', timeout)
    console.log('[dice3d] roll callbackFn:', callbackFn)
  }

  // Resize canvas to fit app window
  _canvas.style.width = window.innerWidth - 8 + 'px'
  _canvas.style.height = window.innerHeight + 'px'
  _canvas.style.display = ''
  _diceBox.start_throw(notation_getter, before_roll, after_roll)
}

export default {
  initialize,
  roll,
  setDiceColor
}