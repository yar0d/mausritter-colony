export const TURN_TRACKER_EMPTY = 0
export const TURN_TRACKER_EMPTY_ICON = ''
export const TURN_TRACKER_LIGHT = 1
export const TURN_TRACKER_LIGHT_ICON = 'light'
export const TURN_TRACKER_MOVE = 2
export const TURN_TRACKER_MOVE_ICON = 'paws'
export const TURN_TRACKER_EAT = 3
export const TURN_TRACKER_EAT_ICON = 'food'

export const TURN_TRACKER_LAST = TURN_TRACKER_EAT

export function trackerTurnColorClass (value) {
  switch (value) {
    case TURN_TRACKER_LIGHT: return 'tracker-turn-light'
    case TURN_TRACKER_MOVE: return ''
    case TURN_TRACKER_EAT: return ''
  }
  return ''
}

export function trackerTurnIcon (value) {
  switch (value) {
    case TURN_TRACKER_LIGHT: return TURN_TRACKER_LIGHT_ICON
    case TURN_TRACKER_MOVE: return TURN_TRACKER_MOVE_ICON
    case TURN_TRACKER_EAT: return TURN_TRACKER_EAT_ICON
  }
  return ''
}

export default {
  TURN_TRACKER_EAT,
  TURN_TRACKER_EAT_ICON,
  TURN_TRACKER_EMPTY,
  TURN_TRACKER_EMPTY_ICON,
  TURN_TRACKER_LAST,
  TURN_TRACKER_LIGHT,
  TURN_TRACKER_LIGHT_ICON,
  TURN_TRACKER_MOVE,
  TURN_TRACKER_MOVE_ICON,
  trackerTurnColorClass,
  trackerTurnIcon
}
