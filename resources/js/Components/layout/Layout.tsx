import Sidebar from "./Sidebar";
import Header from "./Header";
import Footer from "./Footer";
import { ReactNode } from "react";

interface Props {
  children: ReactNode;
}

const Layout = ({ children }: Props) => {
  return (
    <div className="flex h-screen overflow-hidden">
      {/* Sidebar */}
      <Sidebar />

      {/* Main Content */}
      <div className="flex flex-col flex-1">
        <Header />
        <main className="flex-1 p-6 bg-gray-50 overflow-y-auto">{children}</main>
        <Footer />
      </div>
    </div>
  );
};

export default Layout;
