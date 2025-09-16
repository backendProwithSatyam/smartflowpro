import Footer from '@/Components/layout/Footer';
import Header from '@/Components/layout/Header';
import { usePage } from '@inertiajs/react';
import { Sidebar } from 'lucide-react';
import { ReactNode, useState } from 'react';

interface Props {
    children: ReactNode;
}
export default function Authenticated({children}: Props) {
    const user = usePage().props.auth.user;
    return (
        <div className="flex h-screen overflow-hidden">
            <Sidebar />
            <div className="flex flex-col flex-1">
                <Header />
                <main className="flex-1 p-6 bg-gray-50 overflow-y-auto">{children}</main>
                <Footer />
            </div>
        </div>
    );
}
