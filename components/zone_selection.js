"use client";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, SelectGroup, SelectLabel, SelectSeparator, SelectScrollUpButton, SelectScrollDownButton } from "@/components/ui/select"
import { useSearchParams, usePathname, useRouter } from 'next/navigation';


export default function ZoneSelection({ zone, groupedByNegeri }) {
    const searchParams = useSearchParams();
    const pathname = usePathname();
    const router = useRouter();

    const setSelectedLocation = (value) => {
        const currentParams = new URLSearchParams(searchParams.toString());
        currentParams.set('zone', value); // Set or update the 'zone' query param

        // Navigate to the updated URL with query params
        router.push(`${pathname}?${currentParams.toString()}`);
    };
    return (
        <div className="mx-auto rounded-lg p-6 md:w-1/2 xl:w-1/4">
            <Select value={zone} onValueChange={setSelectedLocation} >
                <SelectTrigger>
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
    );
}