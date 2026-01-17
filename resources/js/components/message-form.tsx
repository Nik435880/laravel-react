import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { FileImage } from 'lucide-react';
import { SendHorizontal } from 'lucide-react';
import { Form } from '@inertiajs/react';
import { Room } from '@/types';
import { update } from "@/actions/App/Http/Controllers/RoomController";

export const MessageForm = ({ room }: { room: Room }) => {
    return (
        <Form
            method="PUT"
            className="flex h-16 items-center gap-2 border-t-1 px-6 "
            action={update(room.id)}
            encType="multipart/form-data"
            resetOnSuccess
        >
            <Label htmlFor="text" className="sr-only">Message</Label>
            <Input
                type="text"
                name="text"
                id="text"
                placeholder="Enter message..."
                autoComplete="off"
            />
            <Label htmlFor="images" className="flex items-center justify-center">
                <FileImage size={32} />
            </Label>
            <Input
                id="images"
                name="images[]"
                type="file"
                className="hidden"
                multiple // Allow multiple file selection
            />
            <Button
                type="submit"
                className="rounded-full size-9"
                disabled={!room?.id}
            >
                <SendHorizontal size={32} />
            </Button>
        </Form>
    );
};
