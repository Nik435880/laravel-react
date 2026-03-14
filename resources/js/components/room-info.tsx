
import { Room } from '@/types';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/hooks/use-initials';

export function RoomInfo({ room }: { room: Room }) {
    const getInitials = useInitials();

    return (
        <div className="flex flex-row items-center gap-2">
            <Avatar className="h-8 w-8 overflow-hidden rounded-full">
                <AvatarImage
                    src={room.image_path ? `/storage/${room.image_path}` : ''}
                    alt={`${room.name}'s avatar`}
                />

                <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                    {getInitials(room?.name)}
                </AvatarFallback>
            </Avatar>
            <div className="grid flex-1 text-left text-sm leading-tight">
                <span className="truncate font-medium text-md font-semibold ">{room.name}</span>
            </div>
        </div>
    );
}
