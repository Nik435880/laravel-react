import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Message } from '@/types';

export function MessageUser({ message }: { message: Message }) {
    return (
        <div className="flex flex-row items-center gap-1">
            <Avatar>
                <AvatarImage
                    src={
                        message.user.avatar?.avatar_path
                            ? `/storage/${message.user.avatar.avatar_path}`
                            : `/storage/avatars/default.jpg`
                    }
                    alt={`${message.user.name}`}
                />
            </Avatar>
            <h2 className="font-bold text-blue-500">{message.user.name}</h2>
        </div>
    );
}
