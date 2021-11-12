export default { 
  capFirstLetter(val) {
    if (!val) return ''
    return val.charAt(0).toUpperCase() + val.slice(1);
  },
};