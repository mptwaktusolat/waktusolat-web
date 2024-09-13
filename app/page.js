import React from 'react'
import { Button } from "@/components/ui/button"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, SelectGroup, SelectLabel, SelectSeparator, SelectScrollUpButton, SelectScrollDownButton } from "@/components/ui/select"
import { Clock, MapPin } from 'lucide-react'


export default async function Component({ searchParams }) {
  const zone = (searchParams.zone || 'SGR01').toUpperCase();

  let response = await fetch(`https://api.waktusolat.app/v2/solat/${zone}`)
  let data = await response.json()

  let responseZones = await fetch('https://api.waktusolat.app/zones')
  let dataZones = await responseZones.json()
  console.log(dataZones);


  let negeri = dataZones.find(item => item.jakimCode === zone)

  // Function to group the data by 'negeri'
  const groupByNegeri = (data) => {
    return data.reduce((group, item) => {
      const { negeri } = item;
      if (!group[negeri]) {
        group[negeri] = [];
      }
      group[negeri].push(item);
      return group;
    }, {});
  };

  const groupedByNegeri = groupByNegeri(dataZones);


  // const [selectedLocation, setSelectedLocation] = useState('mecca')


  const date = new Date();
  const today = date.getDate();
  const prayerTimesToday = {
    subuh: data.prayers[today].fajr,
    zohor: data.prayers[today].dhuhr,
    asar: data.prayers[today].asr,
    maghrib: data.prayers[today].maghrib,
    isyak: data.prayers[today].isha,
  }

  const hijriDate = data.prayers[today].hijri;

  return (
    <div className="w-full min-h-screen bg-gray-50">
      <div className="bg-purple-600 text-white p-6">
        <h1 className="text-3xl font-bold mb-2">Waktu Solat Malaysia</h1>
        <div className="flex justify-between items-center">
          <div>
            <p className="text-lg">{hijriDate}</p>
            <p className="text-sm opacity-75">13 September 2024</p>
          </div>

        </div>
      </div>
      <div className="p-6">
        <div className="flex justify-between mb-8">
          {Object.entries(prayerTimesToday).map(([prayerName, prayerTime]) => (
            <div key={prayerName} className="text-center">
              <p className="text-sm font-medium text-gray-500">{prayerName.charAt(0).toUpperCase() + prayerName.slice(1)}</p>
              <p className="text-lg font-semibold text-gray-800">
                {new Intl.DateTimeFormat("en-US", { timeStyle: "short", hourCycle: "h12" }).format(
                  new Date(prayerTime * 1000)
                )}
              </p>
            </div>
          ))}
        </div>
        <div className="bg-purple-50 rounded-lg p-6 text-center">
          <h2 className="text-xl font-semibold text-purple-800 mb-2">Next Prayer</h2>
          <div className="text-4xl font-bold text-purple-600 mb-1">00:45:30</div>
          <p className="text-sm text-purple-700">Until Asr</p>

        </div>
        <div className="mx-auto rounded-lg p-6  md:w-1/2 xl:w-1/4">
          <Select value={zone} >
            {/* <Select value={selectedLocation} onValueChange={setSelectedLocation}> */}
            <SelectTrigger  >
              <SelectValue placeholder="Pilih zon" />
            </SelectTrigger>
            <SelectContent>
              {Object.keys(groupedByNegeri).map((negeri) => (
                <SelectGroup key={negeri}>
                  <SelectLabel>{negeri}</SelectLabel>
                  {groupedByNegeri[negeri].map((item) => (
                    <SelectItem key={item.jakimCode} value={item.jakimCode}>
                      {item.jakimCode} - {item.daerah}
                    </SelectItem>
                  ))}
                </SelectGroup>
              ))}
            </SelectContent>
          </Select>
        </div>
      </div>
    </div>
  )
}