import AppLayout from "@/layouts/app-layout";
import { Form } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { store } from '@/actions/App/Http/Controllers/RoomController';


export default function Create() {

    return (
        <AppLayout>
            <Form action={store()} method="POST" encType="multipart/form-data" className="flex flex-col border-1 gap-4 p-4 mx-auto mt-2 rounded-lg w-full md:w-md">
                <Label htmlFor="name">Room Name</Label>
                <Input type='text' name='name' />
                <Label htmlFor="image">Room Image</Label>
                <Input type='file' name='image' className="mt-2" />
                <Button>Create</Button>
            </Form>
        </AppLayout>
    );
}
