Date.prototype.add = function (sInterval, iNum){
  var dTemp = this;
  if (!sInterval || iNum == 0) return dTemp;
  switch (sInterval.toLowerCase()){
    case "ms":
      dTemp.setMilliseconds(dTemp.getMilliseconds() + iNum);
      break;
    case "s":
      dTemp.setSeconds(dTemp.getSeconds() + iNum);
      break;
    case "mi":
      dTemp.setMinutes(dTemp.getMinutes() + iNum);
      break;
    case "h":
      dTemp.setHours(dTemp.getHours() + iNum);
      break;
    case "d":
      dTemp.setDate(dTemp.getDate() + iNum);
      break;
    case "mo":
      dTemp.setMonth(dTemp.getMonth() + iNum);
      break;
    case "y":
      dTemp.setFullYear(dTemp.getFullYear() + iNum);
      break;
  }
  return dTemp;
}